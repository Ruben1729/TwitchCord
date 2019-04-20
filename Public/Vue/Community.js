import "./Chat/Chat.js";
import "./Channels_Bar.js";
import "./GroupChat_Bar.js";
import "./Stream.js"

Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://localhost:3000',
    forceNew: true,
}));

var app = new Vue({
    el: '#root > #app',
    data: function () {
        return {
            user: {},
            //Socket.IO
            isConnected: true,
            connection: null,
            //Channel
            channels: [],
            groups: [],
            current_channel: null,
            current_group: null,
            //Stream
            isStreamOpen: false,
            css: {
                root: {
                    width: '100%',
                    height: '100%',
                },
                app: {
                    width: '100%',
                    height: '100%',
                    display: 'flex',
                    flexFlow: 'row',
                },
            },
        }
    },
    computed: {},
    watch: {
        channels: function (val) {
            this.channels = val;
            this.current_channel = this.channels[0];
        },
        groups: function (val) {
            this.groups = val;
            this.current_group = this.groups[0];
        },
        current_channel: function (val) {
            this.current_channel = val;
            //reset group chat
            this.current_group = this.groups[0];
        }
    },
    methods: {
        updateConnection(state) {
            console.log('connection state changed')
            this.isConnected = state;
        },
        toggleStreamState(state) {
            console.log('stream-status changed');
            this.isStreamOpen = !this.isStreamOpen;
        },
        getInfo() {
            let vm = this;
            axios.get('/Community/GetInformation')
                .then(function (response) {
                    let data = response.data;
                    vm.channels = data.channels;
                    vm.user = data.user;
                    vm.groups = data.group_chats;
                })
                .catch(function (response) {
                    console.log('Invalid Request: ' + response.data.error);
                })
        },
        channelChange(channel) {
            this.current_channel = channel;
        },
        groupChatChange(group) {
            this.$refs.chat.leaveCurrentGroup();
            this.current_group = group;
            this.isStreamOpen = false;
        },
    },
    created: function () {
        this.getInfo();
    },
    template: `
    <div :style="css.root">
        <div v-if="isConnected" :style="css.app">
            <channel-bar 
                v-bind:channels="channels"
                v-on:channel-change="channelChange">
            </channel-bar>

            <groupchat-bar 
                v-bind:groups="groups"
                v-on:stream-state="toggleStreamState"
                v-on:group-chat-change="groupChatChange">
            </groupchat-bar>

            <stream v-if="isStreamOpen"
                v-bind:channel="current_channel">
            </stream>

            <chat
                ref="chat"
                v-on:connection-state="updateConnection"
                v-bind:isStreamOpen="isStreamOpen"
                v-bind:channel="current_channel"
                v-bind:group="current_group"
                v-bind:user="user">
            </chat>
        </div>
        <div v-else-if="!isConnected">
            NOT CONNECTED
        </div>
    </div>
    `,
});

