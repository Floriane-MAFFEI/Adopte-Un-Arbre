import { createStore, applyMiddleware, compose } from 'redux';
import rootReducer from 'src/reducers';
import projectsMiddleware from '../middlewares/projectsMiddleware';
import treesMiddleware from '../middlewares/treesMiddleware';
import usersMiddleware from '../middlewares/usersMiddleware';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const enhancers = composeEnhancers(
  applyMiddleware(
    projectsMiddleware,
    treesMiddleware,
    usersMiddleware,
  ),
);

const store = createStore(rootReducer, enhancers);

export default store;
