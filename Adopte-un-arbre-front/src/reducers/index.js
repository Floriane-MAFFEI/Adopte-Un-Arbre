import { combineReducers } from 'redux';

import treesReducer from './trees';
import usersReducer from './users';
import projectsReducer from './projects';

const rootReducer = combineReducers({
  projects: projectsReducer,
  trees: treesReducer,
  users: usersReducer,
});

export default rootReducer;
