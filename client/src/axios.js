// // src/axios.js
// import axios from 'axios';

// // Set the base URL for your backend API
// axios.defaults.baseURL = 'http://127.0.0.1:8000';

// // Ensure the CSRF token is sent with requests
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// // Include credentials with requests
// axios.defaults.withCredentials = true;

// // Fetch the CSRF token from the Laravel backend
// axios.get('/csrf-token').then(response => {
//     axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.csrfToken;
//     console.log("success getting token"+ response.data.csrfToken)
// }).catch(error => {
//     console.error('Failed to get CSRF token', error);
// });

// export default axios;
