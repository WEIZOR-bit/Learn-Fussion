import {defineStore} from 'pinia'
import axios from 'axios'
import services from '@/services';

export const useUserStore = defineStore ('userStore', {

    state: () => ({
        emailVerifyQuery: null,
        globalPreloader: false,
        globalModeMessageObject: {
            title: '',
            body: '',
            button: '',
            routeTo: '',
        },
        user: null,
        token: null,
        isLoading: false,
    }),

    actions: {
        setEmailVerifyQuery(query) {
            this.emailVerifyQuery = query;
        },

        setUser(userData) {
            this.user = userData;
        },

        async getUser() {
            await this.fetchUser();
            console.log(this.user);
            return this.user;
        },

        setToken(tokenData) {
            this.token = tokenData;
        },

        logout() {
            this.user = null;
            this.token = null;
        },

        async apiUserVerification() {
            const query = this.emailVerifyQuery;
            console.log(`/verify/${query.id}/${query.hash}?expires=${query.expires}&signature=${query.signature}`);
            const response = await services.patch(
                `/verify/${query.id}/${query.hash}?expires=${query.expires}&signature=${query.signature}`,
                {
                    headers: {
                        'Accept': 'application/json',
                    },
                }
            );
            return Promise.resolve();
        },

        async fetchUser() {
            this.isLoading = true;
            console.log('Fetching user...');
            if (!this.token) {
                this.token = localStorage.getItem('jwt_token');
            }
            try {
                const response = await axios.get('http://0.0.0.0/api/public/me', {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                });
                this.user = response.data;
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            }
            catch (error) {
                console.error('Failed to fetch user:', error);
            }
            finally {
                this.isLoading = false;
            }
        }
    },
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
})