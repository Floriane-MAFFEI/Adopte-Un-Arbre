import http from '../httpServices/http';
import {
  GET_TREES,
  GET_SPECIES,
  CREATE_TREES,
  actionLoadTrees,
  actionLoadspecies,
} from '../actions/trees';

const treesMiddleware = (store) => (next) => async (action) => {
  switch (action.type) {
    case GET_TREES: {
      try {
        const result = await http.get('/trees');

        store.dispatch(actionLoadTrees(result.data));
      }
      catch (error) {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur sur le chargement de la page marché aux arbres',
        });
      }
      break;
    }
    case CREATE_TREES: {
      const {
        treeImage,
        treeSpecie,
        treeZipCode,
        treeCity,
        treePrice,
        treeDescription,
        treeNumber,
      } = store.getState().trees;

      try {
        const result = await http.post('/trees', {
          picture: treeImage,
          specie: treeSpecie,
          zip_code: treeZipCode,
          city: treeCity,
          sprice: treePrice,
          description: treeDescription,
          number: treeNumber,
        }, {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        });

        console.log(result);
      }

      catch (e) {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur lors de l\'ajout, réessayez plus tard.',
        });
      }
      break;
    }
    case GET_SPECIES: {
      try {
        const result = await http.get('/species');

        store.dispatch(actionLoadspecies(result.data));
      }
      catch (error) {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur sur le chargement de la page marché aux arbres',
        });
      }
      break;
    }
    default:
  }
  next(action);
};

export default treesMiddleware;
