import axios from 'axios';

// Add a request interceptor
axios.interceptors.request.use(
  (config) => {
    // Il faut vérifier que le token ne soit pas nul avant de le mettre dans les en-têtes HTTP. Si on ne le fait pas,
    // nos futures requêtes qui ne nécessitent pas de token vont nous renvoyer une erreur.
    if (localStorage.getItem('token') != null) {
      // OR config.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
      config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`;
    }
    config.baseURL = 'http://floriane-maffei-server.eddi.cloud/api';

    return config;
  },
  (error) => Promise.reject(error)
  ,
);

export default {
  get: axios.get,
  post: axios.post,
  put: axios.put,
  delete: axios.delete,
  patch: axios.patch,
};
