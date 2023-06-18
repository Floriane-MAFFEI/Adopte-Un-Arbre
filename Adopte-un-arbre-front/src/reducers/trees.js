import { LOAD_TREES, LOAD_SPECIES } from '../actions/trees';

export const initialState = {
  treesList: [],
  speciesList: [],
  treeImage: '',
  treeSpecie: '',
  treeZipCode: 0,
  treeCity: '',
  treePrice: 0,
  treeDescription: '',
  treeNumber: 0,
};

const reducer = (state = initialState, action = {}) => {
  switch (action.type) {
    case LOAD_TREES:
      return {
        ...state,
        treesList: action.payload,
      };

    case LOAD_SPECIES:
      return {
        ...state,
        speciesList: action.payload,
      };
    default:
      return state;
  }
};

export default reducer;
