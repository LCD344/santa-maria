<template>
    <div class="match-line has-background-dark">
        <div v-text="matchDate" class="tag is-light"/>
        <div class="match-line__data has-text-white">
            <span v-text="match.home_team"/>
            <span class="match-line__data-score">
                <span v-text="match.home_score"/>
                -
                <span v-text="match.away_score"/>
            </span>
            <span v-text="match.away_team"/>
        </div>

        <a :href="match.url || ''" target="_blank">
            <button class="button is-small" :class="{'is-info': match.url}" :disabled="! match.url">
                <FontAwesomeIcon icon="eye"/>
            </button>
        </a>

        <button class="button is-small is-danger" @click="deleteModal = true">
            <FontAwesomeIcon icon="trash"/>
        </button>
        <div class="modal" :class="{'is-active' : deleteModal}">
            <div class="modal-background" @click="close"/>
            <div class="modal-content">
                <section class="modal-card-body has-background-light has-text-left">
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" v-model="pass" required
                                   :disabled="loading">
                            <p v-if="error" class="help is-danger">There was an error, please try again</p>
                        </div>
                    </div>
                    <button class="button is-danger is-fullwidth" :class="{'is-loading' : loading}"
                            @click="deleteMatch">Delete
                    </button>
                </section>
            </div>
            <button class="modal-close is-large" @click="close"/>
        </div>
    </div>
</template>

<script>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

export default {
    name: "MatchLine",
    components: {FontAwesomeIcon},
    props: {
        match: {
            type: Object,
            default() {
                return {
                    id: null,
                    homeTeam: null,
                    awayTeam: null,
                    homeScore: null,
                    awayScore: null,
                }
            }
        }
    },
    data() {
        return {
            currentMatch: this.match,
            deleteModal: false,
            pass: null,
            loading: false,
            error: false
        }
    },

    methods: {
        async deleteMatch() {
            this.loading = true;
            this.error = false;
            try {
                const response = await fetch(`/match/${this.currentMatch._id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: this.pass
                    }),
                });


                if (response.ok) {
                    this.$emit('delete', this.currentMatch._id);
                    this.deleteModal = false;
                } else {
                    this.error = true;
                }


            } catch (error) {
                console.log(error);
            }

            this.loading = false;
        },

        close() {
            this.error = false;
            this.deleteModal = false;
        }
    },
    computed: {
        matchDate() {
            return (new Date(this.match.date)).toLocaleDateString();
        }
    }
}
</script>

<style scoped lang="scss">
.match-line {
    display: flex;
    padding: 5px;
    border-bottom: 1px solid hsl(0, 0%, 29%);
    height: 41px;
    align-items: center;

    &__data {
        text-align: center;
        flex: 1;

        &-score {
            padding: 0 5px;
            font-weight: bold;
        }
    }
}
</style>
