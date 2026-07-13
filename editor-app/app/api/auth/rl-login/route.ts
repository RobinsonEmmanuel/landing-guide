import { NextRequest, NextResponse } from 'next/server';
import jwt from 'jsonwebtoken';

const RL_LOGIN_URL = 'https://api-prod.regionlovers.ai/auth/login';

export async function POST(req: NextRequest) {
  let body: { email?: string; password?: string };
  try {
    body = await req.json();
  } catch {
    return NextResponse.json({ success: false, message: 'Requête invalide.' }, { status: 400 });
  }

  const { email, password } = body;
  if (!email || !password) {
    return NextResponse.json({ success: false, message: 'Email et mot de passe requis.' }, { status: 400 });
  }

  let rlData: any;
  try {
    const rlRes = await fetch(RL_LOGIN_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });

    if (!rlRes.ok) {
      return NextResponse.json(
        { success: false, message: 'Identifiants Region Lovers invalides.' },
        { status: 401 }
      );
    }
    rlData = await rlRes.json();
  } catch {
    return NextResponse.json(
      { success: false, message: "Impossible de contacter l'API Region Lovers." },
      { status: 502 }
    );
  }

  const secret = process.env.JWT_SECRET;
  if (!secret) {
    return NextResponse.json(
      { success: false, message: 'Configuration serveur incomplète (JWT_SECRET manquant).' },
      { status: 500 }
    );
  }

  const name = rlData?.user?.name || rlData?.name || rlData?.firstName || email;
  const token = jwt.sign({ email, name }, secret, { expiresIn: '24h' });

  return NextResponse.json({
    success: true,
    token,
    user: { email, name },
    rlTokens: {
      accessToken: rlData?.accessToken ?? null,
      refreshToken: rlData?.refreshToken ?? null,
    },
  });
}
