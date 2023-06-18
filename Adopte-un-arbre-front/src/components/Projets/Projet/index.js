import { useParams, Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { useEffect } from 'react';
import moment from 'moment';
import { actionGetProjectById } from '../../../actions/projects';

import Header from '../../Header';
import Footer from '../../Footer';

import treeProject2 from '../../../assets/treeProject2.png';

import './styles.scss';

function Projet() {
  const { id } = useParams();

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(actionGetProjectById(id));
  }, [dispatch, id]);

  const project = useSelector((state) => state.projects.project);

  const modifiedParam = id.replace(/ /g, '-');
  useEffect(() => {
    const modifiedUrl = `/projet/${modifiedParam}`;
    window.history.replaceState(null, '', modifiedUrl);
  }, [modifiedParam]);

  const StartDate = project !== null ? moment(project.start_at).format('DD/MM/YYYY') : '';

  const ProjectCompleted = project !== null ? project.status === 'Terminé' : '';

  return (
    <>
      <Header />
      <main>
        {project !== null && (
        <>
          <h3>{project.name}</h3>
          <div className="first-part-projet">
            {/* <img src={project.pictures[0].file_name} alt="tree" /> */}
            <img className="picture-projet" src={treeProject2} alt="tree" />
          </div>
          <div className="second-part-projet">
            <div className="meta_projet">{project.description}</div>
            <div className="meta_projet">Localisation : {project.localization}</div>
            <div className="meta_projet">Organisme : {project.organism.name}</div>
            <div className="meta_projet">Date de début : {StartDate}</div>
            <h1 className="h1_projet">Quels arbres vont être plantés ?</h1>
            <div className="meta_projet">Nom : {project.trees[0].specie.name}</div>
            <div className="meta_projet">Nom scientifique : {project.trees[0].specie.scientific_name}</div>
            <div className="meta_projet">Origine : {project.trees[0].origin}</div>
            <div className="meta_projet">Description : {project.trees[0].specie.description}</div>
          </div>
          <h3>Je veux participer au projet :</h3>
          {ProjectCompleted ? (
            <div className="button-container-projet">
              <p>Projet terminé</p>
            </div>
          ) : (
            <div className="button-container-projet">
              <Link className="button-adopter-projet" to={`/participer/${project.id}/trees`}>Participer !</Link>
            </div>
          )}
        </>
        )}
      </main>
      <Footer />
    </>
  );
}

export default Projet;
