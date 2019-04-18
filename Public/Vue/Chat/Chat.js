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
        current_group: function () {
            return `{${this.group.channel_id}}-[${this.group.group_id}]`;
        }
    },
    watch: {
        channel: function (val) {
            //Set new value
            this.channel = val;
            //Join the new room
            this.$socket.emit('join group-chat', this.current_group);
            //Reset group index
            this.group_index = 0;
        }
    },
    methods: {
        sendMessage: function (data) {
            //Fill in remaining fields
            data.user = this.user;
            data.group = this.current_group;
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
