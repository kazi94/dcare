
import Vue from "vue";

// Add a response interceptor
const axios = window.axios.interceptors.response.use(function (response) {
  // Any status code that lie within the range of 2xx cause this function to trigger
  // Do something with response data
  return response;
}, function (error) {
  // Any status codes that falls outside the range of 2xx cause this function to trigger
  // Do something with response error
  console.log('error :>> ', error);
  return Promise.reject(error);
});
export default axios;