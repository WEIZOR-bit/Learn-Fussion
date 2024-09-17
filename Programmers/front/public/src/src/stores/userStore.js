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
    }),

    actions: {
        setEmailVerifyQuery(query) {
            this.emailVerifyQuery = query;
        },
        // setGlobalPreloaderStore(value) {
        //     this.globalPreloader = value;
        // },
        // setGlobalModeMessageObject(payload) {
        //     this.globalModeMessageObject = payload;
        // },


        async apiUserVerification() {
            const query = this.emailVerifyQuery;
            console.log(`/users/api/v1/users/verify/${query.id}/${query.hash}?expires=${query.expires}&signature=${query.signature}`);
            const response = await services.patch(
                `/users/api/v1/users/verify/${query.id}/${query.hash}?expires=${query.expires}&signature=${query.signature}`,
                {
                    headers: {
                        'Accept': 'application/json',
                    },
                }
            );
            return Promise.resolve();
        }
    }
})