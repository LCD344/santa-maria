<template>
    <section class="section">
        <div class="container is-max-desktop">
            <div class="has-text-right">
                <NewMatch #default="{open}" @new-match="newMatch" :teams="teams">
                    <button class="button is-light" @click="open">Add Match</button>
                </NewMatch>
            </div>
            <div class="matches-wrapper is-rounded">
                <MatchLine v-for="match in matches" :match="match" :key="match.id" @delete="deleteMatch"/>
            </div>
        </div>
    </section>
</template>

<script>
import MatchLine from "./MatchLine";
import NewMatch from "./NewMatch";

export default {
    name: "Matches",
    components: {NewMatch, MatchLine},
    props: {
        matches: {
            type: Object,
            required: true
        }
    },

    methods: {
        newMatch(match) {
            this.$emit('new-match', match);
        },
        deleteMatch(matchId) {
            this.$emit('delete-match', matchId);
        },
    },

    computed: {
        teams() {
            const teams = new Set();

            this.matches.forEach((match) => {
                teams.add(match.home_team);
                teams.add(match.away_team);
            });

            return [...teams].sort();
        }
    }
}
</script>


<style scoped lang="scss">
.matches-wrapper {
    margin-top: 10px;
}
</style>
