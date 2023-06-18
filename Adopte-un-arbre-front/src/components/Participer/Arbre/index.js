import { useParams, Link } from 'react-router-dom';
import { useSelector } from 'react-redux';

import Header from '../../Header';
import Footer from '../../Footer';

import adopt from '../../../assets/adopt.jpg';

function Arbre() {
  const { name } = useParams();
  const treesData = useSelector((state) => state.trees.treesList);
  const Tree = treesData.find((project) => project.name === name);

  return (
    <>
      <Header />
      <main>
        <h3>{Tree.specie.name}</h3>
        <div className="first-Part">
          {/* <img src={Project.pictures[0].file_name} alt="tree" /> */}
          <img src={adopt} alt="tree" />
        </div>
        <div className="second-Part">
          <div className="meta_projet">Nom scientifique : {Tree.specie.scientific_name}</div>
          <div className="meta_projet">Origine : {Tree.origin}</div>
          <div className="meta_projet">{Tree.description}</div>
        </div>
        <h3>Vous souhaitez l'adopter ?</h3>
        <div className="meta_projet_p">Prix : {Tree.price} euros</div>
        <div className="button-container">
          <Link className="button-adopter" to="">Acheter !</Link>
        </div>
      </main>
      <Footer />
    </>
  );
}

export default Arbre;
