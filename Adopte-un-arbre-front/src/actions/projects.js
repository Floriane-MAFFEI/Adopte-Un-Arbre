export const GET_PROJECTS = 'GET_PROJECTS'; // pour le projectsMiddleware
export const LOAD_PROJECTS = 'LOAD_PROJECTS';
export const LOAD_PROJECT = 'LOAD_PROJECT';
export const GET_PROJECTBYID = 'GET_PROJECTBYID';

export const actionGetProjects = () => ({
  type: GET_PROJECTS,
});

export function actionGetProjectById(id) {
  return {
    type: GET_PROJECTBYID,
    payload: id,
  };
}

export const actionLoadProjects = (list) => ({
  type: LOAD_PROJECTS,
  payload: list,
});

export function actionLoadProject(project) {
  return {
    type: LOAD_PROJECT,
    payload: project,
  };
}

