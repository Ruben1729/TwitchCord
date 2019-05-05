import "./VoiceStatus.js";

export default Vue.component('voice-controller', {
    props: {
        voice: Object,
        user: Object,
    },
    data: function () {
        return {
            peers: {},
            media_constraints: { audio: true, video: false },
        }
    },
    computed: {
        in_call: function () {
            return this.voice ? true : false;
        },
        voice_identifier() {
            return `{${this.voice.channel_id}}-[${this.voice.group_chat_id}]V`
        },
    },
    methods: {
        gen_identifier(voice) {
            return `{${voice.channel_id}}-[${voice.group_chat_id}]V`
        },
        setupPeerConnection(config) {
            let vm = this;
            let user_id = config.user_id;
            let peer_connection = new RTCPeerConnection({
                iceServers: [
                    {
                        urls: ["turn:173.194.72.127:19305?transport=udp",
                        ],
                        username: "CKjCuLwFEgahxNRjuTAYzc/s6OMT",
                        credential: "u1SQDR/SQsPQIxXNWQT7czc/G4c="
                    },
                    { urls: ["stun:stun.l.google.com:19302"] }
                ]
            });

            //Save information about the user inside the peer connection
            peer_connection.username = config.username;

            this.peers[user_id] = peer_connection;

            peer_connection.onicecandidate = (event) => {
                if (event.candidate) {
                    vm.$socket.emit('new_ICE_candidate', {
                        user_id,
                        socket_id: config.socket_id,
                        candidate: event.candidate,
                    });
                }
            };

            peer_connection.ontrack = (event) => {
                console.log('Track event');
                document.querySelector(`#audio-${user_id}`).srcObject = event.streams[0];
            }

            peer_connection.onnegotiationneeded = () => {
                peer_connection.createOffer()
                    .then((offer) => {
                        return peer_connection.setLocalDescription(offer);
                    })
                    .then(() => {
                        vm.$socket.emit('voice_chat_offer', {
                            user_id,
                            my_socket_id: vm.$socket.id,
                            socket_id: config.socket_id,
                            sdp: peer_connection.localDescription
                        })
                    });
            };

            peer_connection.oniceconnectionstatechange = () => {
                switch (peer_connection.iceConnectionState) {
                    case "closed":
                    case "failed":
                    case "disconnected":
                        vm.drop_peer(user_id);
                        break;
                }
            };

            peer_connection.onsignalingstatechange = () => {
                switch (peer_connection.signalingState) {
                    case "closed":
                        vm.drop_peer(user_id);
                        break;
                }
            }

            return peer_connection;
        },
        createAudioTag(user_id, stream) {
            let el = document.createElement('audio');
            el.id = `audio-${user_id}`;
            el.srcObject = stream;
            el.autoplay = true;
            this.$refs.tags.append(el);
        },
        delete_peer(user_id) {
            let peerConnection = this.peers[user_id];

            //cleanup
            peerConnection.onicecandidate = null;
            peerConnection.onnegotiationneeded = null;
            peerConnection.oniceconnectionstatechange = null;
            peerConnection.onsignalingstatechange = null;

            //cleanup track;
            let el = document.querySelector(`#audio-${user_id}`);
            el.parentNode.removeChild(el);

            peerConnection.close();
            peerConnection = null;
            delete this.peers[user_id];
        },
        cleanup_voice() {
            for (const user_id in this.peers) {
                this.delete_peer(user_id);
            }
            this.$emit('leaving-voice');
        },
    },
    sockets: {
        recieve_peers(users) {
            console.log('Got users in the voice channel');
            let vm = this;
            //Initialize local stream if it hasn't been created
            if (users) {
                Object.values(users).forEach((user) => {
                    let peerConnection = this.setupPeerConnection(user);

                    navigator.mediaDevices.getUserMedia(this.media_constraints)
                        .then((stream) => {
                            vm.createAudioTag(user.user_id, stream);
                            stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
                        })
                });
            }
        },
        voice_chat_offer(config) {
            let description = new RTCSessionDescription(config.sdp);
            let peerConnection = this.setupPeerConnection(config);
            let constraints = this.media_constraints;
            let vm = this;

            peerConnection.setRemoteDescription(description).then(function () {
                return navigator.mediaDevices.getUserMedia(constraints);
            })
                .then(function (stream) {
                    console.log('Got local stream');
                    vm.createAudioTag(config.user_id, stream);
                    stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
                })
                .then(function () {
                    console.log('Creating answer');
                    return peerConnection.createAnswer();
                })
                .then(function (answer) {
                    console.log('Setting local description');
                    return peerConnection.setLocalDescription(answer)
                })
                .then(function () {
                    console.log('Sending voice_chat_answer');
                    vm.$socket.emit('voice_chat_answer', {
                        user_id: config.user_id,
                        socket_id: config.my_socket_id,
                        sdp: peerConnection.localDescription,
                    });
                    console.log(peerConnection.localDescription);
                });
        },
        voice_chat_answer(config) {
            console.log('accepting offer');
            let description = new RTCSessionDescription(config.sdp);
            let peerConnection = this.peers[config.user_id];
            peerConnection.setRemoteDescription(description);
        },
        new_ICE_candidate(config) {
            let candidate = new RTCIceCandidate(config.candidate);
            let peerConnection = this.peers[config.user_id];
            peerConnection.addIceCandidate(candidate);
        },
    },
    watch: {
        voice: function (newVal, oldVal) {
            console.log('attempting to join voice channel');
            //If we're in a voice chat, leave it
            if (oldVal)
                this.$socket.emit('leave_voice', this.gen_identifier(oldVal));

            //Finally join the new voice chat
            if (newVal) {
                this.$socket.emit('join_voice', {
                    group_chat: this.gen_identifier(newVal),
                });
            }
        },
    },
    template: `
        <div>
            <div ref="tags">
            </div>
            <voice-status 
                @leave-voice="cleanup_voice"
                v-show="in_call"
                :users="peers"/>
        </div>
    `,
});