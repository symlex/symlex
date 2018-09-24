<template>
    <div class="dashboard">
        <h1 class="md-display-1">Welcome to Symlex</h1>
        <p class="md-subheading">
            A complete framework stack for agile Web development based on Symfony and Vue.js
        </p>
        <p>
            Symlex is designed to be simple with few concepts to understand - so that you can start implementing instead of wasting time on Stack Overflow.
            Since its first release in 2014, it has proven to be well suited for rapidly building microservices, CLI and single-page applications. It comes
            complete with working examples from testing to forms and database abstraction. Simply delete what you don't need.
        </p>
        <p>
            The <a href="https://github.com/symlex/di-microkernel">kernel</a> is extremely lean and only creates a Symfony
            service container for bootstrapping any application within its context.
            Using a single container for configuration and dependency injection reduces complexity and leads to improved
            performance compared to Symfony standard edition and many other frameworks.
            It also prevents developers from thoughtlessly installing bundles without understanding
            them. The result is less bloat and simpler, more maintainable and testable code that is fundamental for agile development.
        </p>
        <p>
            Plain classes are used wherever possible to avoid vendor lock-in and enable framework independent code reuse.
        </p>
        <p>
            You can combine the PHP based backend with any JavaScript library or REST client.
            The front-end boilerplate is there for your convenience and puts you straight on track for building
            impressive single-page applications with Webpack and Vue.js.
            A working example for command line applications is included as well.
        </p>
        <p>
            After executing <code>bin/phing dev</code> in a terminal, you can sign in as &quot;admin@example.com&quot; using the password
            &quot;passwd&quot; to access the <router-link to="/users">user management</router-link>. See <code>build.xml</code> for more commands.
            Running <code>composer update</code> will get you the latest updates, clears the cache and automatically rebuilds the
            composer autoloader classmap.
            To open a terminal via Docker, run <code>docker-compose exec php sh</code> in the project directory.
        </p>

        <v-layout row-wrap>
              <v-card dark class="ma-2">
               <v-card-title primary-title>
                  <div>
                    <h3 class="headline mb-0">Contribute</h3>
                    <br>
                    <div>Don't hesitate to ask if you're new to GitHub or open-source
                         development. Any contribution is welcome, even if it's just a tiny pull-request or
                         bug report.</div>
                  </div>
                </v-card-title>

                <v-layout justify-end>
                <v-card-actions>
                  <v-btn flat href="https://github.com/symlex">Visit this project on GitHub</v-btn>
                </v-card-actions>
                </v-layout>
              </v-card>

                <v-card dark class="ma-2">
                 <v-card-title primary-title>
                    <div>
                      <h3 class="headline mb-0">Documentation</h3>
                      <br>
                      <div>A complete walk-through is provided in the README file.
                                                   Please feel free to send an e-mail if you have any questions,
                                                   need help or just want to say hello.</div>
                    </div>
                  </v-card-title>
                  <v-layout justify-end>
                  <v-card-actions>
                    <v-btn flat href="https://github.com/symlex/symlex/blob/master/README.md">Open Documentation</v-btn>
                  </v-card-actions>
                  </v-layout>
                </v-card>

                <v-card dark class="ma-2">
                 <v-card-title primary-title>
                    <div>
                      <h3 class="headline mb-0">About</h3>
                      <br>
                      <div>Symlex is maintained by <a href="https://blog.liquidbytes.net/about">Michael Mayer</a>.
                                                   You can use it for free under the terms of the MIT license.
                                                   Thank you to everyone who has contributed!</div>
                    </div>
                  </v-card-title>

                  <v-layout justify-end>
                  <v-card-actions>
                    <v-btn flat href="https://github.com/symlex/symlex/graphs/contributors">See Contributors</v-btn>
                  </v-card-actions>
                  </v-layout>
                </v-card>
            </v-layout>
    </div>
</template>

<script>
    export default {
        name: 'dashboard',
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
        }
    };
</script>

<style scoped>
    h1, h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }
</style>
