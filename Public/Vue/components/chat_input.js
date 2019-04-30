export default Vue.component('chat-input', {
    data: function () {
        return {

        }
    },
    methods: {
        prepareMessage: function () {
            let msg = this.$refs.input_textarea.value;
            if (msg.length <= 0)
                return;

            this.$emit('send-message', {
                text: msg,
                timestamp: moment().format('YYYY-MM-DD hh:mm:ss')
            });
            //Clear old message
            this.$refs.input_textarea.value = '';
        },
        chatCommands: function (event) {
            //Send Message with the enter button
            if (!event.shiftKey && event.keyCode == 13) {
                this.prepareMessage();
                event.preventDefault();
                return false;
            }
        },
    },
    template: `
    <div id="chat-input">
      <textarea ref="input_textarea"
                v-on:keydown="chatCommands">
      </textarea>
      <button v-on:click="prepareMessage">
              ▶</button>
    </div>
    `,
})

