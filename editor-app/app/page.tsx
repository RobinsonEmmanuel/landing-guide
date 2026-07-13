'use client';

import { useEffect } from 'react';
import { AuthProvider, useAuth } from '@/components/AuthProvider';
import { LoginForm } from '@/components/LoginForm';

function Gate() {
  const { user, loading, logout } = useAuth();

  useEffect(() => {
    function onMessage(event: MessageEvent) {
      if (event.origin !== window.location.origin) return;
      if (event.data?.type === 'rl-session-expired') {
        logout();
      }
    }
    window.addEventListener('message', onMessage);
    return () => window.removeEventListener('message', onMessage);
  }, [logout]);

  if (loading) {
    return <div className="loading-screen">Chargement...</div>;
  }

  if (!user) {
    return <LoginForm />;
  }

  return (
    <div className="editor-shell">
      <div className="editor-topbar">
        <span>Connecté : {user.name || user.email}</span>
        <button onClick={logout}>Déconnexion</button>
      </div>
      <iframe src="/landing-editor.html" className="editor-frame" title="Éditeur Landing Guide" />
    </div>
  );
}

export default function Page() {
  return (
    <AuthProvider>
      <Gate />
    </AuthProvider>
  );
}
