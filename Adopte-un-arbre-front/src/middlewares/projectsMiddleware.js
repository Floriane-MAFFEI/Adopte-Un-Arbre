import axios from 'axios';
import BASE_URL from '../components/App/config';
import {
  GET_PROJECTS,
  GET_PROJECTBYID,
  actionLoadProjects,
  actionLoadProject,
} from '../actions/projects';

const projectsMiddleware = (store) => (next) => async (action) => {
  switch (action.type) {
    case GET_PROJECTS: {
      try {
        const result = await axios.get(`${BASE_URL}/projects`);

        store.dispatch(actionLoadProjects(result.data));
      }
      catch (error) {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur sur le chargement de la page marché aux projets',
        });
      }
      break;
    }

    case GET_PROJECTBYID: {
      try {
        const result = await axios.get(`${BASE_URL}/projects/${action.payload}`);

        store.dispatch(actionLoadProject(result.data));
        localStorage.setItem('project', JSON.stringify(result.data));
      }
      catch (error) {
        store.dispatch({
          type: 'UPDATE_ERROR',
          payload: 'Erreur sur le chargement du projet',
        });
      }
      break;
    }
    default:
  }
  next(action);
};

export default projectsMiddleware;
