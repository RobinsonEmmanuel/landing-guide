import { MongoClient, Db } from 'mongodb';

const DB_NAME = process.env.MONGODB_DB || 'landing_guide_editor';

declare global {
  // eslint-disable-next-line no-var
  var _mongoClientPromise: Promise<MongoClient> | undefined;
}

function getClientPromise(): Promise<MongoClient> {
  const uri = process.env.MONGODB_URI;
  if (!uri) {
    throw new Error('MONGODB_URI manquant dans les variables d\'environnement.');
  }

  if (process.env.NODE_ENV === 'development') {
    // En dev, on réutilise la connexion à travers les rechargements à chaud.
    if (!global._mongoClientPromise) {
      global._mongoClientPromise = new MongoClient(uri).connect();
    }
    return global._mongoClientPromise;
  }

  return new MongoClient(uri).connect();
}

let clientPromise: Promise<MongoClient> | null = null;

export async function getDb(): Promise<Db> {
  if (!clientPromise) clientPromise = getClientPromise();
  const client = await clientPromise;
  return client.db(DB_NAME);
}

export async function getProjectsCollection() {
  const db = await getDb();
  return db.collection('projects');
}
