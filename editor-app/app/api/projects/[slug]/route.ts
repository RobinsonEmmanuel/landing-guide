import { NextRequest, NextResponse } from 'next/server';
import { verifyToken } from '@/lib/verifyToken';
import { getProjectsCollection } from '@/lib/mongodb';

function requireAuth(req: NextRequest) {
  return verifyToken(req.headers.get('authorization'));
}

export async function GET(req: NextRequest, { params }: { params: { slug: string } }) {
  const auth = requireAuth(req);
  if (!auth) {
    return NextResponse.json({ success: false, message: 'Non authentifié.' }, { status: 401 });
  }

  const collection = await getProjectsCollection();
  const doc = await collection.findOne({ slug: params.slug }, { projection: { _id: 0 } });

  if (!doc) {
    return NextResponse.json({ success: false, message: 'Projet introuvable.' }, { status: 404 });
  }

  return NextResponse.json({ success: true, project: doc });
}

export async function PUT(req: NextRequest, { params }: { params: { slug: string } }) {
  const auth = requireAuth(req);
  if (!auth) {
    return NextResponse.json({ success: false, message: 'Non authentifié.' }, { status: 401 });
  }

  let body: { data?: Record<string, unknown>; images?: Record<string, unknown> };
  try {
    body = await req.json();
  } catch {
    return NextResponse.json({ success: false, message: 'Corps de requête invalide.' }, { status: 400 });
  }

  const collection = await getProjectsCollection();
  await collection.updateOne(
    { slug: params.slug },
    {
      $set: {
        slug: params.slug,
        data: body.data || {},
        images: body.images || {},
        updatedAt: new Date().toISOString(),
        updatedBy: auth.email,
      },
    },
    { upsert: true }
  );

  return NextResponse.json({ success: true });
}

export async function DELETE(req: NextRequest, { params }: { params: { slug: string } }) {
  const auth = requireAuth(req);
  if (!auth) {
    return NextResponse.json({ success: false, message: 'Non authentifié.' }, { status: 401 });
  }

  const collection = await getProjectsCollection();
  await collection.deleteOne({ slug: params.slug });

  return NextResponse.json({ success: true });
}
