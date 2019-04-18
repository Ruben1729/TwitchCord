
export default Vue.component('channel-bar', {
    props: {
        channels: Array,
    },
    methods: {
        OnlyCaptials(string) {
            let letters = "";
            string.split('').forEach(character => {
                if (character >= 'A' && character <= 'Z')
                    letters += character;
            });
            return letters;
        }
    },
    data: function () {
        return {
            css: {
                bar: {
                    width: '6em',
                    background: '#272829',
                },
                ul: {
                    margin: '0',
                    padding: '0',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                },
            }
        }
    },
    template: `
    <div :style="css.bar">
        <ul :style="css.ul">
            <li style="list-style-type: none;" v-for="channel in channels">
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