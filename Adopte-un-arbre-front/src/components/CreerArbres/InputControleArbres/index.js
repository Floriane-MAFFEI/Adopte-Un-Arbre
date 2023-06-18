import PropTypes from 'prop-types';

import { useDispatch, useSelector } from 'react-redux';

import { actionUpdateInput } from '../../../actions/users';

import '../styles.scss';

function InputControleArbres({ inputName, ...rest }) {
  const value = useSelector((state) => state[inputName]);

  const dispatch = useDispatch();

  const handleInputChange = (event) => {
    dispatch(actionUpdateInput(event.target.value, inputName));
  };

  return (
    <input value={value} onChange={handleInputChange} {...rest} />
  );
}

InputControleArbres.propTypes = {
  inputName: PropTypes.string.isRequired,
};

export default InputControleArbres;
