export default Vue.component('stream', {
    props: {
        channel: Object,
    },
    data: function () {
        return {

        }
    },
    computed: {
        streamURL: function () {
            return this.channel ? `https://player.twitch.tv/?channel=${this.channel.channel_name}` : ''
        }
    },
    methods: {},
    template: `
    <div id="stream">
        <iframe
            style="width: 100%; height: 85%; margin: 2% 0;"
            v-bind:src="streamURL"
            scrolling="no"
            allowfullscreen="true">
        </iframe>
    </div>
    `,
});