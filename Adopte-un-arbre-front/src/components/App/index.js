/* eslint-disable dot-notation */
import './styles.scss';

import axios from 'axios';

import { Routes, Route } from 'react-router-dom';
import { useEffect } from 'react';

import { useDispatch } from 'react-redux';

import Accueil from '../Accueil';
import ProfilUtilisateur from '../ProfilUtilisateur';
import Participer from '../Participer';
import Projets from '../Projets';
import Projet from '../Projets/Projet';
import GreenTeam from '../GreenTeam';
import Inscription from '../Inscription';
import Connexion from '../Connexion';
import Erreur from '../Erreur';

import { actionGetTrees, actionGetSpecies } from '../../actions/trees';
import { actionGetProjects } from '../../actions/projects';

function App() {
  const dispatch = useDispatch();

  useEffect(
    () => {
      dispatch(actionGetProjects());
      dispatch(actionGetSpecies());
      // dispatch(actionGetCount());
      dispatch(actionGetTrees());

      // TODO à mettre dans un dispatcher.
      // Il faut vérifier que le token ne soit pas nul avant de le mettre dans les en-têtes HTTP. Si on ne le fait pas,
      // nos futures requêtes qui ne nécessitent pas de token vont nous renvoyer une erreur.
      if (localStorage.getItem('token') != null) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
      }
    },
    [],
  );

  const user = JSON.parse(localStorage.getItem('user'));

  const firstName = user.firstname;

  return (
    <div className="app">
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path={`/profil/${firstName}`} element={<ProfilUtilisateur />} />
        <Route path="/participer/:projectId/trees" element={<Participer />} />
        <Route path="/projets" element={<Projets />} />
        <Route path="/projet/:id" element={<Projet />} />
        <Route path="/greenteam" element={<GreenTeam />} />
        <Route path="/inscription" element={<Inscription />} />
        <Route path="/connexion" element={<Connexion />} />
        <Route path="*" element={<Erreur />} />
      </Routes>
    </div>
  );
}

export default App;
