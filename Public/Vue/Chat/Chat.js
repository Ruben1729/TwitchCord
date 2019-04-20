import "./chat_input.js";
import "./chat_window.js";

export default Vue.component('chat', {
    props: {
        channel: Object,
        group: Object,
        user: Object,
    },
    sockets: {
        connect: function () {
            this.$emit('connection-state', true);
            //Don't send join request if group hasn't been set
            if (this.group_identifier) {
                this.joinGroup();
                this.getMessageHistory();
            }
        },
        connect_error: function () {
            this.$emit('connection-state', false);
        },
        message_recieved: function (msg) {
            this.messages.push(msg);
        },
        message_history: function (messages) {
            console.log('History Recieved');
            console.log(messages);
            this.messages = messages;
        },
    },
    data: function () {
        return {
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
        group_identifier: function () {
            if (this.group)
                return `{${this.group.channel_id}}-[${this.group.group_chat_id}]`;
            else
                return null;
        }
    },
    watch: {
        channel: function (val) {
            if (val === undefined)
                return;
            this.joinGroup();
            this.getMessageHistory();
        },
        group: function (val) {
            if (val === undefined)
                return;
            this.messages = [];
            this.joinGroup();
            this.getMessageHistory();
        }
    },
    methods: {
        sendMessage: function (data) {
            //Fill in remaining fields
            data.username = this.user.username;
            data.user_id = this.user.user_id;
            data.group_chat_id = this.group.group_chat_id;
            data.group_chat = this.group_identifier;
            //Send message as JSON
            this.$socket.emit('group-chat_message', data);
            //Insert message into local messages
            this.messages.push(data);
        },
        joinGroup: function () {
            //Join the new room
            this.$socket.emit('join_group-chat', this.group_identifier);
        },
        getMessageHistory: function () {
            this.$socket.emit('retrieve_messages', this.group);
        }
    },
    template: `
    <div :style="css.chat_container">
        <chat-window 
            ref="chat_window" 
            v-bind:messages="messages"></chat-window>
        <chat-input v-on:send-message="sendMessage"></chat-input>
    </div>
    `,
});
