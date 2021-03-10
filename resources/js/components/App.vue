<template>
    <LeagueTable :matches="matches"/>
    <Matches :matches="matches" @new-match="newMatch" @deleteMatch="deleteMatch"/>
</template>

<script>
import Matches from "./Matches";
import LeagueTable from "./LeagueTable";

export default {
    name: "TableMatchManager",
    components: {Matches, LeagueTable},

    props: {
        initialMatches: {
            required: true,
            type: Array
        }
    },

    data() {
        return {
            matches: this.initialMatches.sort(this.sortMatches)
        }
    },

    methods: {
        sortMatches(matchA, matchB) {
            const matchADate = new Date(matchA.date);
            const matchBDate = new Date(matchB.date);
            return matchBDate - matchADate;
        },

        newMatch(match) {
            this.matches.push(match);
            this.matches.sort(this.sortMatches);
        },

        deleteMatch(matchId) {
            const index = this.matches.indexOf((match) => {
                return match._id == matchId;
            });
            this.matches.splice(index, 1)
        }
    }


}
</script>
