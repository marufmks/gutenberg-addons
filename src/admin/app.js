import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

export default function App() {
  const [setting, setSetting] = useState('');

  useEffect(() => {
    apiFetch({ path: '/gutenberg-addons/v1/settings' }).then((res) => {
      setSetting(res?.some_option || '');
    });
  }, []);

  const save = () => {
    apiFetch({
      path: '/gutenberg-addons/v1/settings',
      method: 'POST',
      data: { some_option: setting },
    });
  };

  return (
    <div>
      <h2>Settings</h2>
      <input value={setting} onChange={(e) => setSetting(e.target.value)} />
      <button onClick={save}>Save</button>
    </div>
  );
}
