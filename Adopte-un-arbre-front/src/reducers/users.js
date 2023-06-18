import { UPDATE_INPUT } from '../actions/users';

export const initialState = {
  inscriptionFirstName: '', // fomulaire d'inscription
  inscriptionLastName: '', // fomulaire d'inscription
  inscriptionAdress: '', // fomulaire d'inscription
  inscriptionZipCode: 0, // fomulaire d'inscription
  inscriptionCity: '', // fomulaire d'inscription
  inscriptionEmail: '', // fomulaire d'inscription
  inscriptionRole: '', // fomulaire d'inscription
  inscriptionPassword: '', // fomulaire d'inscription
  inscriptionBirthDate: '', // fomulaire d'inscription
  connexionEmail: '', // fomulaire de connexion
  connexionPassword: '', // fomulaire de connexion
};

const reducer = (state = initialState, action = {}) => {
  switch (action.type) {
    case UPDATE_INPUT:
      return {
        ...state,
        [action.payload.inputName]: action.payload.value,
      };

    default:
      return state;
  }
};

export default reducer;
