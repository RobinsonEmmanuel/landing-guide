import type { Metadata } from 'next';
import './globals.css';

export const metadata: Metadata = {
  title: 'Éditeur Landing Guide — Region Lovers',
  description: 'Éditeur interne des landing pages de vente Region Lovers',
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fr">
      <body>{children}</body>
    </html>
  );
}
