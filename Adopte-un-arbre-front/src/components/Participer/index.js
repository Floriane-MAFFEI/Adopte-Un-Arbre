import { useSelector } from 'react-redux';
import { Link } from 'react-router-dom';

import './styles.scss';
import adopt from '../../assets/adopt.jpg';

import Header from '../Header';
import Footer from '../Footer';

function Participer() {
  const treesData = useSelector((state) => state.trees.treesList);

  return (
    <>
      <Header />
      <main>
        <div className="participer">
          <h2>Marché aux arbres</h2>
        </div>
        <div className="description-page">
          <p>
            Plongez dans l'univers fascinant de votre propre forêt, où chaque arbre raconte une histoire unique. Explorez les différentes espèces et choisissez l’arbre qui vous ressemble.
            C'est ici, au cœur de notre forêt, que vous trouverez la connexion avec la nature que vous recherchez depuis si longtemps.
            N'attendez plus, prenez part à cette aventure humaine au service de notre planète !
          </p>
          <h3>Voir les arbres disponibles :</h3>
          <div className="projects-cards">
            {treesData.map((tree) => (
              <div className="card" key={tree.id}>
                <div className="content-participer">
                  <div className="picture-projects-container">
                    <img className="picture-participer" src={adopt} alt="tree" />
                  </div>
                  <div className="header">{tree.specie.name}</div>
                  <div className="description">{tree.specie.description}</div>
                  <div className="meta">Prix : {tree.price} euros</div>
                  <div className="redirect">
                    <Link className="button-plus-participer" to={`/participer/${tree.name}`}>En savoir plus</Link>
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

export default Participer;
