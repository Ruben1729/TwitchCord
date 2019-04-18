import "./Chat/Chat.js";
import "./Channels_Bar.js";
import "./GroupChat_Bar.js";

Vue.use(new VueSocketIO({
    debug: true,
    connection: 'http://localhost:3000',
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
            group_chats: [],
            channel_index: 0,
            group_chat_index: 0,
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
    computed: {
        current_channel: function () {
            return this.channels[this.channel_index];
        },
        current_group_chat: function () {
            return this.group_chats[this.group_chat_index];
        }
    },
    methods: {
        updateConnection(state) {
            app.isConnected = state;
        },
        getInfo() {
            let vm = this;
            axios.get('/Community/GetInformation')
                .then(function (response) {
                    let data = response.data;
                    vm.channels = data.channels;
                    vm.user = data.user;
                    vm.group_chats = data.group_chats;
                })
                .catch(function (response) {
                    console.log('Invalid Request: ' + response.data.error);
                })
        },
    },
    mounted: function () {
        this.getInfo();
    },
    template: `
    <div :style="css.root">
        <div v-if="isConnected" :style="css.app">
            <channel-bar></channel-bar>
            <groupchat-bar></groupchat-bar>
            <chat v-on:connection-state="updateConnection"
                  v-bind:channel="current_channel"
                  v-bind:group_chat="current_group_chat"
                  v-bind:user="user">
            </chat>
        </div>
        <div v-else-if="!isConnected">
            NOT CONNECTED
        </div>
    </div>
    `,
});

