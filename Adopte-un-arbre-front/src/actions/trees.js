// TREES
export const GET_TREES = 'GET_TREES'; // pour le middleware treesMiddleware.js
export const LOAD_TREES = 'LOAD_TREES'; // pour le reducer trees.js
export const CREATE_TREES = 'CREATE_TREES'; // pour le middleware treesMiddleware.js

// SPECIES
export const GET_SPECIES = 'GET_SPECIES'; // pour le middleware treesMiddleware.js
export const LOAD_SPECIES = 'LOAD_SPECIES'; // pour le reducer trees.js

// TREES
export const actionGetTrees = () => ({
  type: GET_TREES,
});

export const actionLoadTrees = (list) => ({
  type: LOAD_TREES,
  payload: list,
});

export const actionCreateTrees = () => ({
  type: CREATE_TREES,
});

// SPECIES
export const actionGetSpecies = () => ({
  type: GET_SPECIES,
});

export const actionLoadspecies = (list) => ({
  type: LOAD_SPECIES,
  payload: list,
});
