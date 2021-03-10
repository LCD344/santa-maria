<template>
    <section class="hero is-light">
        <div class="hero-body">
            <div class="container is-max-desktop">
                <p class="title">
                    Current Standings:
                </p>
                <table class="table is-fullwidth">
                    <thead>
                    <tr>
                        <td>Team</td>
                        <td>Pld</td>
                        <td class="is-hidden-mobile">For</td>
                        <td class="is-hidden-mobile">Against</td>
                        <td>Diff</td>
                        <td>Pts</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(team, key) in teams" :key="key">
                        <td class="has-text-weight-bold" v-text="team.name"/>
                        <td v-text="team.played"/>
                        <td class="is-hidden-mobile" v-text="team.for"/>
                        <td class="is-hidden-mobile" v-text="team.against"/>
                        <td v-text="team.for - team.against"/>
                        <td class="has-text-weight-bold" v-text="team.points"/>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "LeagueTable",
    props: {
        matches: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            teams: []
        };
    },
    watch: {
        matches: {
            handler() {
                const result = {};
                this.matches.forEach((match) => {
                    if (!result[match.home_team]) {
                        result[match.home_team] = {
                            name: match.home_team,
                            played: 0,
                            for: 0,
                            against: 0,
                            points: 0
                        }
                    }
                    if (!result[match.away_team]) {
                        result[match.away_team] = {
                            name: match.away_team,
                            played: 0,
                            for: 0,
                            against: 0,
                            points: 0
                        }
                    }

                    let homePoints = 1;
                    let awayPoints = 1;
                    if (match.home_score > match.away_score) {
                        homePoints = 3;
                        awayPoints = 0;
                    } else if (match.home_score < match.away_score) {
                        homePoints = 0;
                        awayPoints = 3;
                    }

                    result[match.home_team] = {
                        name: match.home_team,
                        played: result[match.home_team].played += 1,
                        for: result[match.home_team].for += parseInt(match.home_score),
                        against: result[match.home_team].against += parseInt(match.away_score),
                        points: result[match.home_team].points += homePoints,
                    }

                    result[match.away_team] = {
                        name: match.away_team,
                        played: result[match.away_team].played += 1,
                        for: result[match.away_team].for += parseInt(match.away_score),
                        against: result[match.away_team].against += parseInt(match.home_score),
                        points: result[match.away_team].points += awayPoints,
                    }

                    const teams = [];

                    for (let team in result) {
                        teams.push(result[team]);
                    }

                    this.teams = teams.sort((team1, team2) => {
                        if (team1.points < team2.points) {
                            return 1;
                        }
                        if (team1.points > team2.points) {
                            return -1;
                        }
                        if ((team1.for - team1.against) < (team2.for - team2.against)) {
                            return 1;
                        }
                        if ((team1.for - team1.against) > (team2.for - team2.against)) {
                            return -1;
                        }
                        return 0;
                    });

                });
            },
            immediate: true
        }
    }
}
</script>

<style scoped>

</style>
