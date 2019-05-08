import "./components/Channels_Bar.js";
import "./components/GroupChat_Bar.js";
import "./components/Chat.js";
import "./components/Users.js";
import "./components/Stream.js";
import "./components/VoiceController.js";

Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://localhost:3000',
    forceNew: true,
}));

var app = new Vue({
    el: '#root > #app',
    data() {
        return {
            isConnected: false,
            inStream: false,
            user: null,
            current_channel: null,
            current_group: null,
            current_voice: null,
        }
    },
    computed: {
        channel_name() {
            return this.current_channel ? this.current_channel.channel_name : null;
        },
        channel_id() {
            return this.current_channel ? this.current_channel.channel_id : null;
        },
        permission_binary() {
            return this.current_channel ? this.current_channel.permission_binary : null;
        },
    },
    methods: {
        handleChannelSwitch(channel) {
            console.log('Switching channels');
            console.log(channel);
            //Prevent switching to the same channel
            if (this.current_channel == channel)
                return

            if (this.current_channel) {
                this.$socket.emit('leave_channel', this.current_channel.channel_name);
            }
            this.current_channel = channel;
            this.$socket.emit('join_channel', channel.channel_name);
        },
        handleBan(channels) {
            if (this.channel_name == channels.old) {
                alert("You've been removed from the channel");
                this.current_channel = channels.new;
            }
        },
    },
    sockets: {
        connect() {
            this.isConnected = true;
        },
        connect_error() {
            this.isConnected = false;
        },
    },
    created() {
        axios.get('/User/GetCurrentUser/')
            .then(response => {
                this.user = response.data;
                this.$socket.emit('register_user', this.user);
            })
            .catch(response => {
                console.log('Invalid Request: ' + response.data.error);
            })
    },
    template: `
        <div id="app">
            <div v-show="isConnected" id="main-container">
                <channel-bar
                    @channel-change="handleChannelSwitch($event)">
                    @user_yeeted="handleBan"
                </channel-bar>
                
                <div style="display: flex;">
                    <groupchat-bar
                        @group-change="current_group = $event"
                        @voice-change="current_voice = $event"
                        @stream-state="inStream = $event"
                        :channel_id="channel_id">
                    </groupchat-bar>

                    <voice-controller
                        :voice="current_voice"
                        :user="user"
                        @leaving-voice="current_voice = null">
                    </voice-controller>
                </div>

                <stream v-if="inStream"
                    v-bind:channel="current_channel">
                </stream>

                <chat
                    :channel="current_channel"
                    :group="current_group"
                    :user="user"
                    @stream-state="inStream = $event"
                    :inStream="inStream">
                </chat>

                <users 
                    :channel_name="channel_name"
                    :channel_id="channel_id"
                    :permission_binary="permission_binary">
                </users>
                
            </div>
            <div v-show="!isConnected">
                Not Connected
            </div>
        </div>
    `,
});