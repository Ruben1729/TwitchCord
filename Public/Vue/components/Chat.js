import "./chat_input.js";
import "./chat_window.js";

export default Vue.component('chat', {
    props: {
        channel: Object, //Use this for Stream
        group: Object,
        user: Object,
        inStream: Boolean,
    },
    data: function () {
        return {
            messages: [],
        }
    },
    sockets: {
        reconnect() {
            this.joinGroup();
            this.$socket.emit('register_user', this.user);
        },
        message_recieved(msg) {
            this.messages.push(msg);
        },
        message_history(messages) {
            this.messages = messages;
        },
    },
    watch: {
        group: function (updated, old) {
            this.$emit('stream-state', false)
            if (old) this.leaveGroup(old);
            if (updated) {
                this.messages = [];
                this.joinGroup();
            }
        },
        inStream: function (state) {
            this.messages = [];
            //Join stream's livechat
            if (state) {
                this.leaveGroup(this.group);
                this.$socket.emit('join_group-chat', this.channel.channel_name);
            } else {
                this.joinGroup();
            }
        }
    },
    methods: {
        handleMessage(data) {
            if (this.inStream)
                this.sendMessage(data, 'live-chat_message')
            else
                this.sendMessage(data, 'group-chat_message')
        },
        sendMessage(data, emitType) {
            //Fill in remaining fields
            data.username = this.user.username;
            data.user_id = this.user.user_id;
            data.group_chat_id = this.group.group_chat_id;
            data.group_chat = this.group_identifier(this.group);
            data.path = this.user.path;
            //Send message as JSON
            console.log('sending type: ' + emitType);
            this.$socket.emit(emitType, data);
            //Insert message into local messages
            this.messages.push(data);
        },
        group_identifier(group) {
            return `{${group.channel_id}}-[${group.group_chat_id}]`;
        },
        joinGroup() {
            console.log('joinning');
            if (this.group) {
                //Join the new room
                let group_identifier = this.group_identifier(this.group);
                this.$socket.emit('join_group-chat', group_identifier);
                //Get chat history
                this.$socket.emit('retrieve_messages', this.group);
            }
        },
        leaveGroup(group) {
            if (group) {
                let group_identifier = this.group_identifier(group);
                this.$socket.emit('leave_group-chat', group_identifier);
            }
        },
    },
    template: `
    <div id="chat_container">
        <chat-window 
            ref="chat_window" 
            :messages="messages"/>

        <chat-input @send-message="handleMessage"/>
    </div>
    `,
});
