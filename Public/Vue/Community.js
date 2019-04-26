import "./Chat/Chat.js";
import "./Channels_Bar.js";
import "./GroupChat_Bar.js";
import "./Stream.js";
import "./Users.js";

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
            channel_groups: [],
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
        channel_groups: function (val) {
            this.channel_groups = val;
            this.current_group = this.channel_groups[0];
        },
        current_channel: function (val) {
            this.current_channel = val;
            console.log('switching channel');
            //Fetch new groups
            let vm = this;
            axios.get('/Community/GetGroupChats/' + val.channel_id)
                .then(function (response) {
                    vm.channel_groups = response.data;
                })
                .catch(function (response) {
                    console.log('Invalid Request: ' + response.data.error);
                })
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
                })
                .catch(function (response) {
                    console.log('Invalid Request: ' + response.data.error);
                })
        },
        channelChange(channel) {
            //prevent channel from changing to itself
            if (this.current_channel === channel)
                return;

            this.$refs.chat.leaveCurrentGroup();
            this.current_channel = channel;
            this.isStreamOpen = false;
        },
        groupChatChange(group) {
            //prevent group from changing to itself
            if (this.current_group === group)
                return;

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
                v-bind:groups="channel_groups"
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

            <users
                v-bind:channel="current_channel">
            </users>
        </div>
        <div v-else-if="!isConnected">
            NOT CONNECTED
        </div>
    </div>
    `,
});

