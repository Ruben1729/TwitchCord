export default Vue.component('channel-bar', {
    data: function () {
        return {
            channels: [],
        }
    },
    methods: {
        OnlyCaptials(string) {
            let letters = "";
            string.split('').forEach(character => {
                if (character >= 'A' && character <= 'Z')
                    letters += character;
            });
            return letters;
        },
        fetchChannels() {
            axios.get('/Community/GetUserChannels')
                .then(response => {
                    this.channels = response.data.channels;
                    this.$emit('channel-change', this.channels[0]);
                })
                .catch(response => {
                    console.log('Invalid Request: ' + response.data.error);
                })
        },
    },
    created() {
        this.fetchChannels();
    },
    template: `
    <div id="channel-bar">
        <ul>
            <li 
            @click="$emit('channel-change', channel)"
            v-for="channel in channels">
                <template v-if="channel.path">
                    <img class="channel img" :src="channel.path">
                </template>
                <template v-else>
                    <div class="channel noImg">
                    <span style="vertical-align: middle">{{OnlyCaptials(channel.channel_name)}}</span>
                    </div> 
                </template>
            </li>
        </ul>
    </div>
    `,
});