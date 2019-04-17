export default Vue.component('chat-window', {
  props: {
    messages: Array,
  },
  data: function () {
    return {
      //CSS
      css: {
        messages: {
          listStyleType: 'none',
        },
        window: {
          width: '100%',
          flex: '1',
          background: '#829399',
        },
      },
    }
  },
  template: `
  <div :style="css.window">
    <ul>
      <li :style="css.messages" v-for="message in messages">
        <div class="msg">
          <div class="avatar">
              <img v-bind:src="message.user.path" class="msg-img" />
              <p class="username">{{message.user.username}}</p>
          </div>
          <p class="msg-content">{{message.content}}</p>
          <div class="timestamp">{{message.timestamp}}</div>
        </div>
      </li>
    </ul>
  </div>
  `,
})