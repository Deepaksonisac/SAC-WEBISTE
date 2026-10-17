/* Vanilla three.js port of components/hero-scene.tsx (three.js is vendored, no build step). */
import {
  AmbientLight,
  BufferGeometry,
  Clock,
  Color,
  Fog,
  Group,
  IcosahedronGeometry,
  InstancedMesh,
  LineBasicMaterial,
  LineSegments,
  Mesh,
  MeshBasicMaterial,
  MeshStandardMaterial,
  Object3D,
  PerspectiveCamera,
  PointLight,
  Scene,
  SphereGeometry,
  TorusGeometry,
  Vector3,
  WebGLRenderer,
  Float32BufferAttribute,
} from './vendor/three.module.min.js';

function start(canvas) {
  let renderer;
  try {
    renderer = new WebGLRenderer({ canvas, antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (err) {
    return;
  }

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.8));

  const scene = new Scene();
  scene.fog = new Fog('#eef6ee', 12, 24);
  const camera = new PerspectiveCamera(45, 1, 0.1, 100);
  camera.position.set(0, 0, 12);

  scene.add(new AmbientLight('#ffffff', 1));
  const l1 = new PointLight('#86efac', 40, 0, 2);
  l1.position.set(10, 10, 10);
  const l2 = new PointLight('#2dd4a7', 25, 0, 2);
  l2.position.set(-10, -6, -8);
  scene.add(l1, l2);

  const typeColors = [new Color('#4ade80'), new Color('#2dd4a7'), new Color('#86efac')];
  const nodeCount = 26;
  const nodes = [];
  for (let i = 0; i < nodeCount; i++) {
    const shell = i % 2 === 0 ? 3.1 : 4.2;
    const y = 1 - (i / (nodeCount - 1)) * 2;
    const r = Math.sqrt(1 - y * y);
    const theta = i * 2.399963;
    const pos = new Vector3(Math.cos(theta) * r, y, Math.sin(theta) * r).multiplyScalar(shell);
    pos.x += (Math.sin(i * 12.9) % 0.4) * 0.6;
    pos.z += (Math.cos(i * 4.7) % 0.4) * 0.6;
    nodes.push({ position: pos, color: typeColors[i % 3], phase: (i / nodeCount) * Math.PI * 2 });
  }

  const hub = new Vector3();
  const edges = [];
  nodes.forEach((n, i) => {
    if (i % 2 === 0) edges.push([hub, n.position]);
    edges.push([n.position, nodes[(i + 3) % nodes.length].position]);
  });

  const network = new Group();
  scene.add(network);

  const linePoints = [];
  edges.forEach(([a, b]) => linePoints.push(a.x, a.y, a.z, b.x, b.y, b.z));
  const lineGeo = new BufferGeometry();
  lineGeo.setAttribute('position', new Float32BufferAttribute(linePoints, 3));
  network.add(new LineSegments(lineGeo, new LineBasicMaterial({ color: '#3f9e6b', transparent: true, opacity: 0.3 })));

  const dummy = new Object3D();
  const nodeMesh = new InstancedMesh(
    new IcosahedronGeometry(1, 1),
    new MeshStandardMaterial({ color: '#08160e', emissive: '#22c55e', emissiveIntensity: 1.4, toneMapped: false }),
    nodes.length,
  );
  nodes.forEach((n, i) => nodeMesh.setColorAt(i, n.color));
  network.add(nodeMesh);

  const offsets = edges.map((_, i) => (i * 0.61803398875) % 1);
  const pulseMesh = new InstancedMesh(new SphereGeometry(1, 8, 8), new MeshBasicMaterial({ color: '#bbf7d0', toneMapped: false }), edges.length);
  network.add(pulseMesh);

  const hubMesh = new Mesh(
    new IcosahedronGeometry(1, 2),
    new MeshStandardMaterial({ color: '#dcfce7', emissive: '#4ade80', emissiveIntensity: 1.8, roughness: 0.2, metalness: 0.6, toneMapped: false }),
  );
  const ring = new Mesh(
    new TorusGeometry(1.15, 0.02, 12, 80),
    new MeshStandardMaterial({ color: '#34d399', emissive: '#34d399', emissiveIntensity: 2, toneMapped: false }),
  );
  ring.rotation.x = Math.PI / 2.3;
  network.add(hubMesh, ring);

  const pointer = { x: 0, y: 0 };
  window.addEventListener(
    'pointermove',
    (e) => {
      pointer.x = (e.clientX / window.innerWidth) * 2 - 1;
      pointer.y = -((e.clientY / window.innerHeight) * 2 - 1);
    },
    { passive: true },
  );

  function resize() {
    const w = canvas.clientWidth;
    const h = canvas.clientHeight;
    if (!w || !h) return;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
  }
  new ResizeObserver(resize).observe(canvas);
  resize();

  const clock = new Clock();
  let visible = true;
  let running = false;

  function frame() {
    if (!visible || document.hidden) {
      running = false;
      return;
    }
    const delta = Math.min(clock.getDelta(), 0.1);
    const t = clock.elapsedTime;

    nodes.forEach((n, i) => {
      dummy.position.copy(n.position);
      dummy.scale.setScalar(0.14 + Math.sin(t * 1.6 + n.phase) * 0.045);
      dummy.updateMatrix();
      nodeMesh.setMatrixAt(i, dummy.matrix);
    });
    nodeMesh.instanceMatrix.needsUpdate = true;

    edges.forEach(([a, b], i) => {
      const raw = (t * 0.28 + offsets[i]) % 1;
      dummy.position.lerpVectors(a, b, raw);
      dummy.scale.setScalar(0.07 * Math.sin(raw * Math.PI) + 0.01);
      dummy.updateMatrix();
      pulseMesh.setMatrixAt(i, dummy.matrix);
    });
    pulseMesh.instanceMatrix.needsUpdate = true;

    hubMesh.scale.setScalar(0.62 + Math.sin(t * 1.2) * 0.03);
    hubMesh.rotation.y += delta * 0.4;
    ring.rotation.z += delta * 0.6;

    if (!reducedMotion) network.rotation.y += delta * 0.12;
    network.rotation.x += (pointer.y * 0.25 - network.rotation.x) * 0.04;
    network.position.x += (pointer.x * 0.4 - network.position.x) * 0.04;
    network.position.y += (-pointer.y * 0.3 - network.position.y) * 0.04;

    renderer.render(scene, camera);
    requestAnimationFrame(frame);
  }

  function run() {
    if (running) return;
    running = true;
    clock.getDelta();
    requestAnimationFrame(frame);
  }

  new IntersectionObserver((entries) => {
    visible = entries[0].isIntersecting;
    if (visible) run();
  }).observe(canvas);
  document.addEventListener('visibilitychange', () => {
    if (!document.hidden) run();
  });

  renderer.render(scene, camera);
  canvas.classList.add('is-ready');
  run();
}

const canvas = document.getElementById('sac-hero-canvas');
if (canvas) start(canvas);
