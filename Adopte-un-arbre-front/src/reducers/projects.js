import { LOAD_PROJECTS, LOAD_PROJECT } from '../actions/projects';
import { UPDATE_INPUT } from '../actions/users';

export const initialState = {
  list: [],
  project: null,
  projectName: '',
  projectZipCode: 0,
  projectCity: '',
  projectDate: '',
  projectStock: 0,
  projectImage: '',
};

const reducer = (state = initialState, action = {}) => {
  switch (action.type) {
    case LOAD_PROJECTS:
      return {
        ...state,
        list: action.payload,
      };

    case LOAD_PROJECT:
      return {
        ...state,
        project: action.payload,
      };

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
