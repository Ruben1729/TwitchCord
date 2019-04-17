import "./chat_input.js";
import "./chat_window.js";

export default Vue.component('chat', {
    props: {
        channel: Object,
        user: Object,
    },
    sockets: {
        connect: function () {
            this.$emit('connection-state', true);
        },
        connect_error: function () {
            this.$emit('connection-state', false);
        },
        message_recieved: function (msg) {
            this.messages.push(msg);
        }
    },
    data: function () {
        return {
            group_chat_index: 0,
            messages: [],
            css: {
                chat_container: {
                    display: 'flex',
                    flex: '1',
                    flexDirection: 'column',
                    overflow: 'hidden',
                    background: '#545f66',
                },
            },
        }
    },
    computed: {
        current_group_chat: function () {
            return `{${this.channel.channel_name}}-[test]`;
        }
    },
    watch: {
        channel: function (val) {
            //Set new value
            this.channel = val;
            //Join the new room
            this.$socket.emit('join group-chat', this.current_group_chat);
            //Reset group_chat index
            this.group_chat_index = 0;
        }
    },
    methods: {
        sendMessage: function (data) {
            //Fill in remaining fields
            data.user = this.user;
            data.group_chat = this.current_group_chat;
            //Send message as JSON
            this.$socket.emit('group-chat message', data);
            //Insert message into local messages
            this.messages.push(data);
        },
    },
    template: `
    <div :style="css.chat_container">
        <chat-window v-bind:messages="messages"></chat-window>
        <chat-input v-on:send-message="sendMessage"></chat-input>
    </div>
    `,
});
