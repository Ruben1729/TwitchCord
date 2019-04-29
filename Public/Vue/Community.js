import "./components/Channels_Bar.js"
import "./components/GroupChat_Bar.js"
import "./components/Chat.js"
import "./components/Users.js"
import "./components/Stream.js"

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
            current_channel: null,
            current_group: null,
        }
    },
    computed: {
        channel_name() {
            return this.current_channel ? this.current_channel.channel_name : null;
        },
        channel_id() {
            return this.current_channel ? this.current_channel.channel_id : null;
        }
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
    },
    sockets: {
        connect() {
            this.isConnected = true;
        },
        connect_error() {
            this.isConnected = false;
        },
    },
    template: `
        <div id="app">
            <div v-show="isConnected" id="main-container">
                <channel-bar
                    @channel-change="handleChannelSwitch($event)"/>
                
                <groupchat-bar
                    @group-change="current_group = $event"
                    @stream-state="inStream = $event"
                    :channel_id="channel_id"/>

                <stream v-if="inStream"
                    v-bind:channel="current_channel">
                </stream>

                <chat
                    :channel="current_channel"
                    :group="current_group"
                    @stream-state="inStream = $event"
                    :inStream="inStream"/>

                <users 
                    :channel_name="channel_name"
                    :channel_id="channel_id"/>
                
            </div>
            <div v-show="!isConnected">
                Not Connected
            </div>
        </div>
    `,
});