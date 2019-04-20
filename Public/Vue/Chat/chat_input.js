export default Vue.component('chat-input', {
    data: function () {
        return {
            css: {
                input: {
                    minHeight: '1em',
                    maxHeight: '2em',
                    width: '100%',
                    padding: '2% 0',
                    display: 'flex',
                    alignItems: 'center',
                },
                input_textarea: {
                    margin: '1% 0% 1% 1%',
                    padding: '0',
                    float: 'left',
                    resize: 'none',
                    width: '100%',
                    height: '100%',
                },
                input_button: {
                    margin: '0',
                    marginRight: '1%',
                    height: '100%',
                    width: '50px',
                    float: 'left',
                },
            },
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
    <div :style="css.input">
      <textarea ref="input_textarea"
                :style="css.input_textarea"
                v-on:keydown="chatCommands">
      </textarea>
      <button :style="css.input_button"
              v-on:click="prepareMessage">
              ▶</button>
    </div>
    `,
})

