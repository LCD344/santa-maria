<template>
    <div>
        <slot :open="open"/>
        <div class="modal" :class="{'is-active' : active}">
            <div class="modal-background" @click="close"/>
            <div class="modal-content">
                <section class="modal-card-body has-background-light has-text-left">
                    <form @submit.prevent="submit">
                        <div class="field">
                            <label class="label">Date</label>
                            <div class="control">
                                <input class="input" type="date" v-model="match.date" required
                                       :disabled="loading">
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Home Team</label>
                                    <div class="control">
                                        <input class="input" type="text" v-model="match.homeTeam" required
                                               list="homeTeam"
                                               :disabled="loading">
                                        <datalist id="homeTeam">
                                            <option v-for="team in teams" :value="team" :key="team"/>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-one-fifth">
                                <div class="field">
                                    <label class="label">Score</label>
                                    <div class="control">
                                        <input class="input" type="number" min="0" v-model="match.homeScore" required
                                               :disabled="loading">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <div class="field">
                                    <label class="label">Away Team</label>
                                    <div class="control">
                                        <input class="input" type="text" v-model="match.awayTeam" required
                                               list="awayTeam"
                                               :disabled="loading">
                                        <datalist id="awayTeam">
                                            <option v-for="team in teams" :value="team" :key="team"/>
                                        </datalist>

                                    </div>
                                </div>
                            </div>
                            <div class="column is-one-fifth">
                                <div class="field">
                                    <label class="label">Score</label>
                                    <div class="control">
                                        <input class="input" type="number" min="0" v-model="match.awayScore" required
                                               :disabled="loading">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Videos Url</label>
                            <div class="control">
                                <input class="input" type="url" v-model="match.url"
                                       :disabled="loading">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" v-model="match.password" required
                                       :disabled="loading">
                                <p v-if="error" class="help is-danger">There was an error, please try again</p>
                            </div>
                        </div>
                        <button class="button is-dark is-fullwidth" :class="{'is-loading' : loading}"
                                :disabled="! canSave">Save
                        </button>
                    </form>
                </section>

            </div>
            <button class="modal-close is-large" @click="close"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewMatch",
    props: {
        teams: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {
            active: false,
            loading: false,
            match: {
                date: null,
                homeTeam: null,
                homeScore: null,
                awayTeam: null,
                awayScore: null,
                url: null,
                password: null
            },
            error: null
        }
    },
    computed: {
        canSave() {
            return this.match.homeTeam !== null &&
                this.match.awayTeam !== null &&
                this.match.homeScore !== null &&
                this.match.awayScore !== null &&
                this.match.homeTeam != this.match.awayTeam;
        }
    },
    methods: {
        open() {
            this.active = true;
        },
        close() {
            if (this.loading) {
                return;
            }

            this.active = false;
        },
        async submit() {
            this.loading = true;
            try {
                const response = await fetch('/match', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.match),
                });

                if (response.ok) {
                    const responseJson = await response.json();
                    this.$emit('new-match', responseJson.match);
                    this.active = false;
                } else {
                    this.error = true;
                }

            } catch (error) {
                console.log(error);
            }

            this.loading = false;

        }
    }
}
</script>

