export default Vue.component('voice-status', {
    props: {
        users: Object
    },
    data: function () {
        return {

        }
    },
    methods: {

    },
    template: `
    <div>
        <button @click="$emit('leave-voice', true)">
            Leave Call
        </button>
        <ul>
            <li v-for="user in users">
                {{ user.username }}
            </li>
        </ul>
    </div>
    `,
});