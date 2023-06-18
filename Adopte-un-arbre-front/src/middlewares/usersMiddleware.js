import http from '../httpServices/http';
import { CHECK_LOGIN, SIGN_UP } from '../actions/users';

const usersMiddleware = (store) => (next) => async (action) => {
  switch (action.type) {
    case CHECK_LOGIN: {
      const { connexionEmail, connexionPassword } = store.getState().users;

      try {
        const result = await http.post('/login_check', {
          email: connexionEmail,
          password: connexionPassword,
        });

        localStorage.setItem('token', result.data.token);
        localStorage.setItem('user', JSON.stringify(result.data.user));
        window.location = '/projets';
      }

      catch {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur de connexion : mauvais mot de passe ou mauvais email',
        });
      }
      break;
    }
    case SIGN_UP: {
      const {
        inscriptionFirstName,
        inscriptionLastName,
        inscriptionAdress,
        inscriptionZipCode,
        inscriptionCity,
        inscriptionEmail,
        inscriptionRole,
        inscriptionPassword,
      } = store.getState().users;

      if (inscriptionRole === 'ROLE_MANAGER') {
        const {
          inscriptionSiret,
          inscriptionName,
          inscriptionPhoneNumber,
          inscriptionDescription,
        } = store.getState().users;

        try {
          const result = await http.post('/users', {
            firstname: inscriptionFirstName,
            lastname: inscriptionLastName,
            address: inscriptionAdress,
            zip_code: inscriptionZipCode,
            city: inscriptionCity,
            email: inscriptionEmail,
            password: inscriptionPassword,
            roles: inscriptionRole,
            siret_insee: inscriptionSiret,
            name: inscriptionName,
            phoneNumber: inscriptionPhoneNumber,
            description: inscriptionDescription,
          });
          console.log(result);
        }

        catch {
          store.dispatch({
            type: 'UPDATE_ERROR',
            payload: 'Erreur',
          });
        }
      }
      else if (inscriptionRole === 'ROLE_USER') {
        const { inscriptionBirthDate } = store.getState().users;

        try {
          const result = await http.post('/users', {
            firstname: inscriptionFirstName,
            lastname: inscriptionLastName,
            address: inscriptionAdress,
            zip_code: inscriptionZipCode,
            city: inscriptionCity,
            email: inscriptionEmail,
            password: inscriptionPassword,
            roles: inscriptionRole,
            date_of_birth: inscriptionBirthDate,
          });
          console.log(result);
        }

        catch {
          store.dispatch({
            type: 'UPDATE_ERROR',
            payload: 'Erreur',
          });
        }
      }
      break;
    }
    default:
  }
  return next(action);
};
export default usersMiddleware;
