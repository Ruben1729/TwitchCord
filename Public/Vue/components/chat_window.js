
export default Vue.component('chat-window', {
  props: {
    messages: Array,
  },
  methods: {
    resolvePath: function (imgsrc) {
      return imgsrc ? imgsrc : '/Pictures/default.png'
    },
    getTime: function (time) {
      return moment(time).format('hh:mm A')
    },
  },
  updated: function () {
    //Scroll the chat box to the bottom of the UL tag
    this.$refs.ul_message.scrollTop = this.$refs.ul_message.scrollHeight;
  },
  data: function () {
    return {

    }
  },
  template: `
  <div id="chat-window">
    <ul ref="ul_message">
      <li class="messages" v-for="message in messages">
        <div class="avatar">
            <img :src="resolvePath(message.path)"/>
            <p>{{message.username}}</p>
        </div>
        <p>{{message.text}}</p>
        <div class="timestamp">{{getTime(message.timestamp)}}</div>
      </li>
    </ul>
  </div>
  `,
})