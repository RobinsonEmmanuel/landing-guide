'use client';

import { createContext, useContext, useEffect, useState, ReactNode } from 'react';

type AuthUser = { email: string; name?: string };

type LoginResult = { success: boolean; message?: string };

type AuthContextValue = {
  user: AuthUser | null;
  token: string | null;
  loading: boolean;
  login: (email: string, password: string) => Promise<LoginResult>;
  logout: () => void;
};

const AuthContext = createContext<AuthContextValue | null>(null);

function decodeExpiry(token: string): number | null {
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    return typeof payload.exp === 'number' ? payload.exp * 1000 : null;
  } catch {
    return null;
  }
}

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const storedToken = localStorage.getItem('auth_token');
    const storedUser = localStorage.getItem('user_info');

    if (storedToken && storedUser) {
      const expiresAt = decodeExpiry(storedToken);
      if (expiresAt && expiresAt > Date.now()) {
        try {
          setUser(JSON.parse(storedUser));
          setToken(storedToken);
        } catch {
          /* données corrompues, on ignore */
        }
      } else {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_info');
        localStorage.removeItem('rl_tokens');
      }
    }
    setLoading(false);

    function onSessionExpired() {
      setUser(null);
      setToken(null);
    }
    window.addEventListener('session-expired', onSessionExpired);
    return () => window.removeEventListener('session-expired', onSessionExpired);
  }, []);

  async function login(email: string, password: string): Promise<LoginResult> {
    const res = await fetch('/api/auth/rl-login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });
    const json = await res.json();
    if (!res.ok || !json.success) {
      return { success: false, message: json.message || 'Connexion refusée.' };
    }
    localStorage.setItem('auth_token', json.token);
    localStorage.setItem('user_info', JSON.stringify(json.user));
    localStorage.setItem('rl_tokens', JSON.stringify(json.rlTokens || {}));
    setToken(json.token);
    setUser(json.user);
    return { success: true };
  }

  function logout() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_info');
    localStorage.removeItem('rl_tokens');
    setUser(null);
    setToken(null);
  }

  return (
    <AuthContext.Provider value={{ user, token, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth(): AuthContextValue {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error('useAuth doit être utilisé à l\'intérieur de <AuthProvider>');
  return ctx;
}
