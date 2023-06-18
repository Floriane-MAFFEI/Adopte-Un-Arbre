import { useState, useEffect } from 'react';
import { useSelector } from 'react-redux';
import { Link } from 'react-router-dom';

import './styles.scss';

import Header from '../Header';
import Footer from '../Footer';

import treeProject from '../../assets/treeProject.png';

// https://stackoverflow.com/questions/71252337/filter-button-with-javascript-react

function Projets() {
  const projectsData = useSelector((state) => state.projects.list);
  const [filterProjects, setFilterProjects] = useState(projectsData);
  const [currentStatus, setCurrentStatus] = useState('Tous');

  const handleButton = (status) => {
    setCurrentStatus(status);
  };

  useEffect(() => {
    if (currentStatus === 'Tous') {
      setFilterProjects(projectsData);
    }
    else {
      const filter = projectsData.filter((project) => project.status === currentStatus);
      setFilterProjects(filter);
    }
  }, [currentStatus, projectsData]);

  return (
    <>
      <Header />
      <main>
        <div className="projets">
          <h2>Marché aux projets</h2>
        </div>
        <div className="description-page">
          <p>
            Reforestez la France !
            C'est ici, au cœur de nos projets terminés et en cours, que vous découvrirez les organismes qui œuvrent chaque jour à la reforestation. Grâce à votre participation, ensemble, nous redonnerons à la Terre les poumons qu'elle mérite.
          </p>
          <h3>Voir les projets :</h3>
          <div className="filter-buttons">
            <button onClick={() => handleButton('Tous')} type="button">Tous</button>
            <button onClick={() => handleButton('Commence bientôt')} type="button">Commence bientôt</button>
            <button onClick={() => handleButton('En cours')} type="button">En cours</button>
            <button onClick={() => handleButton('Terminé')} type="button">Terminés</button>
          </div>
          <div className="projects-cards">
            {filterProjects.map((project) => (
              <div className="card" key={project.id}>
                <div className="content">
                  <div className="picture-projects-container">
                    <img className="picture-projets" src={treeProject} alt="tree" />
                  </div>
                  <div className="header">{project.name}</div>
                  <div className="description">{project.description}</div>
                  <div className="meta">Localisation : {project.localization}</div>
                  <div className="meta">Organisme : {project.organism.name}</div>
                  <div className="meta">Statut : {project.status}</div>
                  <div className="redirect">
                    <Link className="button-plus-projets" to={`/projet/${project.id}`}>En savoir plus</Link>
                  </div>
                </div>
              </div>
            ))}
          </div>
          <Footer />
        </div>
      </main>
    </>
  );
}

export default Projets;
