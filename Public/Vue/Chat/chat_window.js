
export default Vue.component('chat-window', {
  props: {
    messages: Array,
  },
  methods: {
    resolvePath: function (imgsrc) {
      return imgsrc ? imgsrc : '/Pictures/default.png'
    },
    getTime: function (time) {
      return moment(time).format("hh:mm:ss A");
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
        avatar: {
          display: 'flex',
          alignItems: 'center',
          flexDirection: 'column',
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
        ul: {
          margin: '2%',
          background: 'white',
          borderRadius: '10px',
          maxHeight: '92%',
          overflow: 'auto',
        },
        msgContent: {
          padding: '2%',
          width: '80%',
          height: '50%',
        },
      },
    }
  },
  template: `
  <div :style="css.window">
    <ul :style="css.ul">
      <li :style="css.messages" v-for="message in messages">
        <div :style="css.msg">
          <div :style="css.avatar">
              <img :src="resolvePath(message.path)" :style="css.msgImg" />
              <p>{{message.user.username}}</p>
          </div>
          <p :style="css.msgContent">{{message.content}}</p>
          <div :style="css.timestamp">{{getTime(message.timestamp)}}</div>
        </div>
      </li>
    </ul>
  </div>
  `,
})