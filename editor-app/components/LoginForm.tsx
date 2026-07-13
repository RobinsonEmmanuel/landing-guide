'use client';

import { FormEvent, useState } from 'react';
import { useAuth } from './AuthProvider';

export function LoginForm() {
  const { login } = useAuth();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  async function handleSubmit(e: FormEvent) {
    e.preventDefault();
    setError('');
    setLoading(true);
    const result = await login(email, password);
    setLoading(false);
    if (!result.success) setError(result.message || 'Erreur de connexion.');
  }

  return (
    <div className="login-wrap">
      <form onSubmit={handleSubmit} className="login-card">
        <h1>Éditeur Landing Guide</h1>
        <p className="login-sub">Connexion avec votre compte Region Lovers</p>

        <label>
          Email
          <input
            type="email"
            value={email}
            onChange={e => setEmail(e.target.value)}
            required
            autoFocus
            autoComplete="username"
          />
        </label>

        <label>
          Mot de passe
          <input
            type="password"
            value={password}
            onChange={e => setPassword(e.target.value)}
            required
            autoComplete="current-password"
          />
        </label>

        {error && <p className="login-error">{error}</p>}

        <button type="submit" disabled={loading}>
          {loading ? 'Connexion...' : 'Se connecter'}
        </button>
      </form>
    </div>
  );
}
