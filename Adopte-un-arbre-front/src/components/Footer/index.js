import './styles.scss';
import logo from '../../assets/logo.png';

function Footer() {
  return (
    <div className="footer">
      <img src={logo} alt="logo-adopte-un-arbre" />
      <div className="text_footer">
        <a className="GreenTeam">Green Team</a>
        <p>© Copyright site réalisé par des superbes développeuses ❤️</p>
      </div>
    </div>
  );
}

export default Footer;
