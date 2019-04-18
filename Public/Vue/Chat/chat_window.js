
export default Vue.component('chat-window', {
  props: {
    messages: Array,
  },
  methods: {
    resolvePath: function (imgsrc) {
      return imgsrc ? imgsrc : '/Pictures/default.png'
    }
  },
  data: function () {
    return {
      //CSS
      css: {
        messages: {
          listStyleType: 'none',
        },
        msg: {
          position: 'relative',
          display: 'flex',
        },
        msgImg: {
          margin: '10px',
          height: '40px',
          width: '40px',
          borderRadius: '50%',
        },
        timestamp: {
          padding: '10px',
          margin: '10px',
          height: '50%',
          position: 'absolute',
          bottom: '0',
          right: '0',
        },
        window: {
          width: '100%',
          flex: '1',
          background: '#829399',
        },
        msgContent: {
          margin: '10px',
          width: '80%',
          height: '50%',
        },
      },
    }
  },
  template: `
  <div :style="css.window">
    <ul>
      <li :style="css.messages" v-for="message in messages">
        <div :style="css.msg">
          <div>
              <img v-bind:src="resolvePath(message.path)" :style="css.msgImg" />
              <p>{{message.user.username}}</p>
          </div>
          <p :style="css.msgContent">{{message.content}}</p>
          <div :style="css.timestamp">{{message.timestamp}}</div>
        </div>
      </li>
    </ul>
  </div>
  `,
})