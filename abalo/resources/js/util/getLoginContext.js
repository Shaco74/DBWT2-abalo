import axios from 'axios';

export async function getLoginContext() {
    try {
        const response = await axios.get('/isloggedin');
        return {
            isLoggedIn: response.data.auth === "true",
            userId: response.data.user_id,
            user: response.data.user,
            time: response.data.time,
            mail: response.data.mail
        };
    } catch (error) {
        console.error('Error fetching session data:', error);
        return {
            isLoggedIn: false,
            userId: null,
            user: null,
            time: null,
            mail: null
        };
    }
}
