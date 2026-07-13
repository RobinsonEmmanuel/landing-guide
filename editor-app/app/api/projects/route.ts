import { NextRequest, NextResponse } from 'next/server';
import { verifyToken } from '@/lib/verifyToken';
import { getProjectsCollection } from '@/lib/mongodb';

export async function GET(req: NextRequest) {
  const auth = verifyToken(req.headers.get('authorization'));
  if (!auth) {
    return NextResponse.json({ success: false, message: 'Non authentifié.' }, { status: 401 });
  }

  const collection = await getProjectsCollection();
  const docs = await collection
    .find({}, { projection: { slug: 1, updatedAt: 1, updatedBy: 1, _id: 0 } })
    .sort({ updatedAt: -1 })
    .toArray();

  return NextResponse.json({ success: true, projects: docs });
}
