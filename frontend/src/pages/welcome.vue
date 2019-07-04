<template>
    <div class="page-welcome">
        <v-toolbar dark flat color="grey">
            <v-toolbar-title>Welcome to Symlex</v-toolbar-title>
        </v-toolbar>

        <div class="pa-4">
            <h1 class="headline">
                A lean framework stack for agile Web development based on Symfony and Vuetify
            </h1>
            <p class="body-1">
                Symlex is designed to be simple with few concepts to understand - so that you can start implementing
                instead of wasting time on Stack Overflow.
                Since its first release in 2014, it has proven to be well suited for rapidly building microservices, CLI
                and single-page applications. It comes
                complete with working examples from testing to forms and database abstraction. Simply delete what you
                don't need.
            </p>
            <p>
                The <a href="https://github.com/symlex/di-microkernel" target="_blank">kernel</a> is extremely lean and only creates a
                service container for bootstrapping your application within its context.
                Using a single container for configuration and dependency injection reduces complexity and leads to
                improved performance compared to other frameworks.
                It also prevents developers from thoughtlessly installing bundles without understanding
                them. The result is less bloat and simpler, more maintainable and testable code that is fundamental for
                agile development.
            </p>
            <p>
                Plain classes are used wherever possible to avoid vendor lock-in and enable framework independent code
                reuse.
            </p>
            <p>
                You can combine the PHP based backend with any JavaScript library or REST client.
                The front-end boilerplate is there for your convenience and puts you straight on track for building
                impressive single-page applications with Webpack and Vuetify.
                A working example for command line applications is included as well.
            </p>
            <p>
                After executing <code>bin/phing build</code> in a terminal, you can sign in as &quot;admin@example.com&quot;
                using the password &quot;passwd&quot; to access the <router-link to="/users">user management</router-link>.
                See <code>build.xml</code> for more commands.
                Running <code>composer update</code> will get you the latest updates, clears the cache and automatically
                rebuilds the composer autoloader classmap.
                To open a terminal via Docker, run <code>docker-compose exec php sh</code> in the project directory.
            </p>
            <h2 class="title pt-2">
                About
            </h2>
            <p>
                Symlex is maintained by <a href="https://blog.liquidbytes.net/about/" target="_blank">Michael Mayer</a> and
                aims to simplify agile Web development by providing a working system that promotes best practices by example.
                Michael released his <a href="http://freshmeat.sourceforge.net/projects/awf" target="_blank">first PHP framework</a> in 2001 and
                has worked with various major framework vendors in the past.
                Building this would not have been possible without a lot of prior work by other developers.
                Thank you to those and everyone who contributed!
            </p>

            <v-container fluid grid-list-md class="pt-3 pl-0 pr-0 pb-0">
                <v-layout row wrap>
                    <v-flex d-flex sm12 md4>
                        <v-card color="blue-grey lighten-5">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="title mb-0">Contribute</h3>
                                    <br>
                                    <div>Don't hesitate to ask if you're new to GitHub or open-source
                                        development. Any contribution is welcome, even if it's just a tiny pull-request
                                        or bug report.
                                    </div>
                                </div>
                            </v-card-title>

                            <v-layout justify-end>
                                <v-card-actions>
                                    <v-btn flat href="https://github.com/symlex">Visit this project on GitHub</v-btn>
                                </v-card-actions>
                            </v-layout>
                        </v-card>
                    </v-flex>

                    <v-flex d-flex sm12 md4>
                        <v-card color="blue-grey lighten-5">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="title mb-0">Documentation</h3>
                                    <br>
                                    <div>A complete walk-through is provided in our README file.
                                        Feel free to send an e-mail to <a href="mailto:hello@symlex.org">hello@symlex.org</a> if you have any questions
                                        or just want to say hello.
                                    </div>
                                </div>
                            </v-card-title>

                            <v-layout justify-end>
                                <v-card-actions>
                                    <v-btn flat href="https://github.com/symlex/symlex/blob/master/README.md">Open
                                        Documentation
                                    </v-btn>
                                </v-card-actions>
                            </v-layout>
                        </v-card>
                    </v-flex>

                    <v-flex d-flex sm12 md4>
                        <v-card color="blue-grey lighten-5">
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="title mb-0">License</h3>
                                    <br>
                                    <div>
                                        You can use and share Symlex for free under the terms of the MIT license.
                                        <a href="https://blog.liquidbytes.net/contact/">Commercial support</a> is available on request.
                                    </div>
                                </div>
                            </v-card-title>

                            <v-layout justify-end>
                                <v-card-actions>
                                    <v-btn flat href="https://github.com/symlex/symlex/graphs/contributors">See
                                        Contributors
                                    </v-btn>
                                </v-card-actions>
                            </v-layout>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'page-welcome',
        data() {
            return {
                msg: 'Welcome to Symlex',
                username: this.$session.getFullName(),
            };
        },
        methods: {
            open() {
                this.$refs.snackbar.open();
            },

            showNotification() {
                this.$alert.success('Yeah wuwuwu');
            },

            logout() {
                this.$session.logout();
            },
        },
        computed: {
            binding() {
                const binding = {}

                if (this.$vuetify.breakpoint.smAndDown) binding.column = true

                return binding
            }
        }
    };
</script>