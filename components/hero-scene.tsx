'use client'

import { Canvas, useFrame, useThree } from '@react-three/fiber'
import { Line } from '@react-three/drei'
import { Component, type ReactNode, useMemo, useRef, useState } from 'react'
import { useTheme } from 'next-themes'
import * as THREE from 'three'

/* ------------------------------------------------------------------ */
/*  Network graph data                                                 */
/* ------------------------------------------------------------------ */

type NodeType = 'camera' | 'gate' | 'sensor'

interface SacNode {
  position: THREE.Vector3
  type: NodeType
  phase: number
}

const TYPE_COLOR: Record<NodeType | 'hub', THREE.Color> = {
  hub: new THREE.Color('#dcfce7'),
  camera: new THREE.Color('#4ade80'),
  gate: new THREE.Color('#2dd4a7'),
  sensor: new THREE.Color('#86efac'),
}

function useNetwork() {
  return useMemo(() => {
    const nodeCount = 26
    const nodes: SacNode[] = []
    const types: NodeType[] = ['camera', 'gate', 'sensor']

    // Distribute nodes over two spherical shells (Fibonacci sphere)
    for (let i = 0; i < nodeCount; i++) {
      const shell = i % 2 === 0 ? 3.1 : 4.2
      const y = 1 - (i / (nodeCount - 1)) * 2
      const r = Math.sqrt(1 - y * y)
      const theta = i * 2.399963
      const pos = new THREE.Vector3(
        Math.cos(theta) * r,
        y,
        Math.sin(theta) * r,
      ).multiplyScalar(shell)
      // slight jitter so it feels organic
      pos.x += (Math.sin(i * 12.9) % 0.4) * 0.6
      pos.z += (Math.cos(i * 4.7) % 0.4) * 0.6
      nodes.push({
        position: pos,
        type: types[i % 3],
        phase: (i / nodeCount) * Math.PI * 2,
      })
    }

    // Edges: every node connects toward the hub + nearest neighbour
    const edges: { a: THREE.Vector3; b: THREE.Vector3 }[] = []
    const hub = new THREE.Vector3(0, 0, 0)
    nodes.forEach((n, i) => {
      if (i % 2 === 0) edges.push({ a: hub.clone(), b: n.position.clone() })
      // connect to a neighbour to form the mesh
      const neighbour = nodes[(i + 3) % nodes.length]
      edges.push({ a: n.position.clone(), b: neighbour.position.clone() })
    })

    return { nodes, edges }
  }, [])
}

/* ------------------------------------------------------------------ */
/*  Pulsing nodes (instanced)                                          */
/* ------------------------------------------------------------------ */

function Nodes({ nodes }: { nodes: SacNode[] }) {
  const ref = useRef<THREE.InstancedMesh>(null)
  const dummy = useMemo(() => new THREE.Object3D(), [])

  useFrame((state) => {
    const mesh = ref.current
    if (!mesh) return
    const t = state.clock.elapsedTime
    nodes.forEach((n, i) => {
      const pulse = 0.14 + Math.sin(t * 1.6 + n.phase) * 0.045
      dummy.position.copy(n.position)
      dummy.scale.setScalar(pulse)
      dummy.updateMatrix()
      mesh.setMatrixAt(i, dummy.matrix)
    })
    mesh.instanceMatrix.needsUpdate = true
  })

  return (
    <instancedMesh
      ref={ref}
      args={[undefined, undefined, nodes.length]}
      onUpdate={(mesh) => {
        nodes.forEach((n, i) => mesh.setColorAt(i, TYPE_COLOR[n.type]))
        if (mesh.instanceColor) mesh.instanceColor.needsUpdate = true
      }}
    >
      <icosahedronGeometry args={[1, 1]} />
      <meshStandardMaterial
        emissive="#22c55e"
        emissiveIntensity={1.4}
        color="#08160e"
        toneMapped={false}
      />
    </instancedMesh>
  )
}

/* ------------------------------------------------------------------ */
/*  Central control hub                                                */
/* ------------------------------------------------------------------ */

function Hub() {
  const ref = useRef<THREE.Mesh>(null)
  const ringRef = useRef<THREE.Mesh>(null)

  useFrame((state, delta) => {
    if (ref.current) {
      const s = 0.62 + Math.sin(state.clock.elapsedTime * 1.2) * 0.03
      ref.current.scale.setScalar(s)
      ref.current.rotation.y += delta * 0.4
    }
    if (ringRef.current) ringRef.current.rotation.z += delta * 0.6
  })

  return (
    <group>
      <mesh ref={ref}>
        <icosahedronGeometry args={[1, 2]} />
        <meshStandardMaterial
          color="#dcfce7"
          emissive="#4ade80"
          emissiveIntensity={1.8}
          roughness={0.2}
          metalness={0.6}
          toneMapped={false}
        />
      </mesh>
      <mesh ref={ringRef} rotation={[Math.PI / 2.3, 0, 0]}>
        <torusGeometry args={[1.15, 0.02, 12, 80]} />
        <meshStandardMaterial
          color="#34d399"
          emissive="#34d399"
          emissiveIntensity={2}
          toneMapped={false}
        />
      </mesh>
    </group>
  )
}

/* ------------------------------------------------------------------ */
/*  Connecting lines                                                   */
/* ------------------------------------------------------------------ */

function Edges({ edges }: { edges: { a: THREE.Vector3; b: THREE.Vector3 }[] }) {
  return (
    <>
      {edges.map((e, i) => (
        <Line
          key={i}
          points={[e.a, e.b]}
          color="#3f9e6b"
          lineWidth={0.6}
          transparent
          opacity={0.3}
        />
      ))}
    </>
  )
}

/* ------------------------------------------------------------------ */
/*  Light travelling along the edges (instanced)                       */
/* ------------------------------------------------------------------ */

function Pulses({ edges }: { edges: { a: THREE.Vector3; b: THREE.Vector3 }[] }) {
  const ref = useRef<THREE.InstancedMesh>(null)
  const dummy = useMemo(() => new THREE.Object3D(), [])
  const offsets = useMemo(
    () => edges.map((_, i) => (i * 0.61803398875) % 1),
    [edges],
  )

  useFrame((state) => {
    const mesh = ref.current
    if (!mesh) return
    const t = state.clock.elapsedTime
    edges.forEach((e, i) => {
      const raw = (t * 0.28 + offsets[i]) % 1
      dummy.position.lerpVectors(e.a, e.b, raw)
      const fade = Math.sin(raw * Math.PI)
      dummy.scale.setScalar(0.07 * fade + 0.01)
      dummy.updateMatrix()
      mesh.setMatrixAt(i, dummy.matrix)
    })
    mesh.instanceMatrix.needsUpdate = true
  })

  return (
    <instancedMesh ref={ref} args={[undefined, undefined, edges.length]}>
      <sphereGeometry args={[1, 8, 8]} />
      <meshBasicMaterial color="#bbf7d0" toneMapped={false} />
    </instancedMesh>
  )
}

/* ------------------------------------------------------------------ */
/*  Rotating group with mouse parallax                                 */
/* ------------------------------------------------------------------ */

function Network({ reducedMotion }: { reducedMotion: boolean }) {
  const group = useRef<THREE.Group>(null)
  const { nodes, edges } = useNetwork()
  const { pointer } = useThree()

  useFrame((state, delta) => {
    const g = group.current
    if (!g) return
    if (!reducedMotion) g.rotation.y += delta * 0.12
    // parallax tilt toward the pointer
    const targetX = pointer.y * 0.25
    const targetZ = -pointer.x * 0.15
    g.rotation.x += (targetX - g.rotation.x) * 0.04
    g.position.x += (pointer.x * 0.4 - g.position.x) * 0.04
    g.position.y += (-pointer.y * 0.3 - g.position.y) * 0.04
    void targetZ
  })

  return (
    <group ref={group}>
      <Edges edges={edges} />
      <Nodes nodes={nodes} />
      <Pulses edges={edges} />
      <Hub />
    </group>
  )
}

/* ------------------------------------------------------------------ */
/*  Canvas + error boundary + reduced-motion / WebGL fallback          */
/* ------------------------------------------------------------------ */

function StaticFallback() {
  return (
    <div
      aria-hidden="true"
      className="h-full w-full"
      style={{
        background:
          'radial-gradient(60% 60% at 70% 40%, rgba(34,197,94,0.22), rgba(240,247,240,0) 70%), radial-gradient(40% 40% at 30% 70%, rgba(45,212,167,0.16), rgba(240,247,240,0) 70%)',
      }}
    />
  )
}

class WebGLBoundary extends Component<
  { children: ReactNode; fallback: ReactNode },
  { failed: boolean }
> {
  state = { failed: false }
  static getDerivedStateFromError() {
    return { failed: true }
  }
  render() {
    return this.state.failed ? this.props.fallback : this.props.children
  }
}

export function HeroScene() {
  const { resolvedTheme } = useTheme()
  const isDark = resolvedTheme === 'dark'
  const fogColor = isDark ? '#132018' : '#eef6ee'

  const [reducedMotion] = useState(() => {
    if (typeof window === 'undefined') return false
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches
  })

  return (
    <WebGLBoundary fallback={<StaticFallback />}>
      <Canvas
        camera={{ position: [0, 0, 12], fov: 45 }}
        dpr={[1, 1.8]}
        gl={{ antialias: true, alpha: true, powerPreference: 'high-performance' }}
        style={{ width: '100%', height: '100%' }}
      >
        <ambientLight intensity={isDark ? 0.6 : 1} />
        <pointLight position={[10, 10, 10]} intensity={40} color="#86efac" />
        <pointLight position={[-10, -6, -8]} intensity={25} color="#2dd4a7" />
        <Network reducedMotion={reducedMotion} />
        <fog attach="fog" args={[fogColor, 12, 24]} />
      </Canvas>
    </WebGLBoundary>
  )
}

export default HeroScene
