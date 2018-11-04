<template>
    <div class="container">
        <div class="row justify-content-center content-wrapper">
            <div>
                <b-form @submit="onSubmit">
                    <b-form-group id="exampleInputGroup1"
                                  label="Popularity of term on Github"
                                  label-for="exampleInput1">
                        <b-form-input id="exampleInput1"
                                      v-model="form.term"
                                      placeholder="Enter term">
                        </b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
                <div class="card card-default">
                    <div class="card-header">{{termInfo.title}}</div>
                    <div class="card-body">
                        Score: {{termInfo.score}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data () {
            return {
                form: {
                    term: '',
                },
                termInfo: {
                    title: '',
                    score: '',
                }
            }
        },
        methods: {
            onSubmit (evt) {
                evt.preventDefault();
                // Api call that passes data to search endpoint
                axios.post('api/term', {
                    term: this.form.term
                })
                    .then((response) => {
                        let info = response.data;
                        this.termInfo.title = info.term;
                        this.termInfo.score = info.score;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        created(){
            // Api call for receiving auth token
            axios.get('/api/token')
                .then((response) => {
                    axios.defaults.headers.common = {
                        "Authorization": `Bearer ${response.data}`
                    };
                })
                .catch(function (error) {
                    console.log(error);
                });
            // This is api example call for new api
           /* axios.post('api/v2/term', {
                term: 'yellow'
            })
                .then((response) => {
                    console.log(response)

                })
                .catch(function (error) {
                    console.log(error);
                });*/
        }
    }
</script>

<style lang="scss">
    .content-wrapper{
        display: flex;
        min-height: 100%;
        align-items: center;
        align-content: center;
    }
</style>
