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
                    this.channels = response.data;
                }).catch(() => {
                    console.log('Error in request');
                })
        },
    },
    watch: {
        channels(val) {
            //If there are any channels, switch to the first one
            if (val) {
                this.$emit('channel-change', this.channels[0]);
            }
        }
    },
    created() {
        this.fetchChannels();
    },
    sockets: {
        user_channel_out(channel_name) {
            this.channels = this.channels.filter(x => x.channel_name == channel_name);
            this.$emit('user_yeeted', { old: channel_name, new: this.channels[0] });
        },
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